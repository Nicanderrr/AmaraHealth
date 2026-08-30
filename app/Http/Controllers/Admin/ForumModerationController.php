<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumModerationController extends Controller
{
    public function index(): View
    {
        return view('admin.forum.index', [
            'topics' => ForumTopic::query()
                ->withCount('replies')
                ->latest('last_reply_at')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function show(ForumTopic $topic): View
    {
        $topic->load(['user', 'moderator', 'replies.user', 'replies.moderator']);

        return view('admin.forum.show', [
            'topic' => $topic,
            'flagReasons' => $this->flagReasons(),
        ]);
    }

    public function toggleLock(ForumTopic $topic): RedirectResponse
    {
        $topic->update([
            'is_locked' => ! $topic->is_locked,
        ]);

        AuditLog::create([
            'admin_id' => request()->user()->id,
            'action' => $topic->is_locked ? 'lock_forum_topic' : 'unlock_forum_topic',
            'target_entity_type' => ForumTopic::class,
            'target_entity_id' => (string) $topic->getKey(),
            'reason' => 'Moderation action from admin forum panel.',
        ]);

        return back()->with('status', 'Topic updated.');
    }

    public function destroy(ForumTopic $topic): RedirectResponse
    {
        AuditLog::create([
            'admin_id' => request()->user()->id,
            'action' => 'delete_forum_topic',
            'target_entity_type' => ForumTopic::class,
            'target_entity_id' => (string) $topic->getKey(),
            'reason' => 'Removed via admin forum moderation.',
        ]);

        $topic->delete();

        return back()->with('status', 'Topic removed.');
    }

    public function moderateTopic(Request $request, ForumTopic $topic): RedirectResponse
    {
        $data = $this->validatedModerationData($request);

        $topic->update([
            'moderation_status' => $data['moderation_status'],
            'moderation_reason' => $data['moderation_reason'],
            'moderation_note' => $data['moderation_note'] ?? null,
            'is_hidden' => $request->boolean('is_hidden'),
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        $this->log($request->user(), 'moderate_forum_topic', ForumTopic::class, $topic->getKey(), $data['moderation_reason']);

        if (in_array($data['moderation_status'], ['flagged', 'needs_professional_review'], true)) {
            $this->notifyProfessionals($topic, 'A forum topic needs professional review.');
        }

        return back()->with('status', 'Topic moderation updated.');
    }

    public function moderateReply(Request $request, ForumTopic $topic, ForumReply $reply): RedirectResponse
    {
        abort_unless((int) $reply->forum_topic_id === (int) $topic->getKey(), 404);

        $data = $this->validatedModerationData($request);

        $reply->update([
            'moderation_status' => $data['moderation_status'],
            'moderation_reason' => $data['moderation_reason'],
            'moderation_note' => $data['moderation_note'] ?? null,
            'is_hidden' => $request->boolean('is_hidden'),
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        $this->log($request->user(), 'moderate_forum_reply', ForumReply::class, $reply->getKey(), $data['moderation_reason']);

        if (in_array($data['moderation_status'], ['flagged', 'needs_professional_review'], true)) {
            $this->notifyProfessionals($topic, 'A forum reply needs professional review.');
        }

        return back()->with('status', 'Reply moderation updated.');
    }

    public function contactTopicAuthor(Request $request, ForumTopic $topic): RedirectResponse
    {
        return $this->contactForumAuthor($request, $topic, $topic->user_id, 'contact_forum_topic_author');
    }

    public function contactReplyAuthor(Request $request, ForumTopic $topic, ForumReply $reply): RedirectResponse
    {
        abort_unless((int) $reply->forum_topic_id === (int) $topic->getKey(), 404);

        return $this->contactForumAuthor($request, $topic, $reply->user_id, 'contact_forum_reply_author');
    }

    private function validatedModerationData(Request $request): array
    {
        return $request->validate([
            'moderation_status' => ['required', 'string', 'in:none,flagged,needs_professional_review,reviewed,clarified'],
            'moderation_reason' => ['required', 'string', 'in:misinformation,unsafe_advice,abuse,private_info,needs_clarification,other'],
            'moderation_note' => ['nullable', 'string', 'max:2000'],
            'is_hidden' => ['nullable', 'boolean'],
        ]);
    }

    private function contactForumAuthor(Request $request, ForumTopic $topic, ?int $recipientId, string $action): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1200'],
        ]);

        if (! $recipientId) {
            return back()->withErrors(['message' => 'This post is not linked to a registered user account.']);
        }

        Notification::create([
            'recipient_id' => $recipientId,
            'type' => 'forum_moderator_contact',
            'message' => $data['message'],
            'linked_entity_type' => ForumTopic::class,
            'linked_entity_id' => (string) $topic->getKey(),
        ]);

        $this->log($request->user(), $action, ForumTopic::class, $topic->getKey(), 'Moderator contacted forum author.');

        return back()->with('status', 'The user has been contacted through their notification inbox.');
    }

    private function notifyProfessionals(ForumTopic $topic, string $message): void
    {
        User::query()
            ->where('role', 'professional')
            ->get()
            ->each(function (User $professional) use ($topic, $message) {
                Notification::create([
                    'recipient_id' => $professional->id,
                    'type' => 'forum_needs_review',
                    'message' => $message,
                    'linked_entity_type' => ForumTopic::class,
                    'linked_entity_id' => (string) $topic->getKey(),
                ]);
            });
    }

    private function log(User $user, string $action, string $targetType, int|string|null $targetId, ?string $reason): void
    {
        AuditLog::create([
            'admin_id' => $user->id,
            'action' => $action,
            'target_entity_type' => $targetType,
            'target_entity_id' => (string) $targetId,
            'reason' => $reason,
        ]);
    }

    private function flagReasons(): array
    {
        return [
            'misinformation' => 'Misinformation',
            'unsafe_advice' => 'Unsafe advice',
            'abuse' => 'Abuse or harassment',
            'private_info' => 'Private information exposed',
            'needs_clarification' => 'Needs professional clarification',
            'other' => 'Other',
        ];
    }
}
