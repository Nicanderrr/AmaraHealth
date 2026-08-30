<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumReviewController extends Controller
{
    public function index(): View
    {
        return view('professional.forum.index', [
            'topics' => ForumTopic::query()
                ->withCount('replies')
                ->where(function ($query) {
                    $query
                        ->whereIn('moderation_status', ['flagged', 'needs_professional_review'])
                        ->orWhereHas('replies', fn ($replyQuery) => $replyQuery->whereIn('moderation_status', ['flagged', 'needs_professional_review']));
                })
                ->latest('moderated_at')
                ->latest('last_reply_at')
                ->paginate(10),
        ]);
    }

    public function show(ForumTopic $topic): View
    {
        $topic->load(['user', 'moderator', 'replies.user', 'replies.moderator']);

        return view('professional.forum.show', [
            'topic' => $topic,
            'flagReasons' => $this->flagReasons(),
        ]);
    }

    public function moderateTopic(Request $request, ForumTopic $topic): RedirectResponse
    {
        $data = $this->validatedModerationData($request);

        $topic->update([
            'moderation_status' => $data['moderation_status'],
            'moderation_reason' => $data['moderation_reason'],
            'moderation_note' => $data['moderation_note'] ?? null,
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        $this->log($request->user(), 'professional_review_forum_topic', ForumTopic::class, $topic->getKey(), $data['moderation_reason']);

        return back()->with('status', 'Topic review updated.');
    }

    public function moderateReply(Request $request, ForumTopic $topic, ForumReply $reply): RedirectResponse
    {
        abort_unless((int) $reply->forum_topic_id === (int) $topic->getKey(), 404);

        $data = $this->validatedModerationData($request);

        $reply->update([
            'moderation_status' => $data['moderation_status'],
            'moderation_reason' => $data['moderation_reason'],
            'moderation_note' => $data['moderation_note'] ?? null,
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        $this->log($request->user(), 'professional_review_forum_reply', ForumReply::class, $reply->getKey(), $data['moderation_reason']);

        return back()->with('status', 'Reply review updated.');
    }

    public function clarify(Request $request, ForumTopic $topic): RedirectResponse
    {
        if ($topic->is_locked) {
            return back()->withErrors(['body' => 'This discussion is locked. Ask an admin to unlock it before posting a clarification.']);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:3000'],
        ]);

        $topic->replies()->create([
            'user_id' => $request->user()->id,
            'anonymous_name' => trim($request->user()->professional_title ?: $request->user()->name) ?: 'Professional',
            'body' => $data['body'],
            'is_professional_clarification' => true,
            'moderation_status' => 'clarified',
            'moderation_reason' => 'needs_clarification',
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        $topic->update([
            'moderation_status' => 'clarified',
            'moderation_reason' => $topic->moderation_reason ?: 'needs_clarification',
            'moderated_by_id' => $request->user()->id,
            'moderated_at' => now(),
            'last_reply_at' => now(),
        ]);

        if ($topic->user_id) {
            Notification::create([
                'recipient_id' => $topic->user_id,
                'type' => 'forum_professional_clarification',
                'message' => 'A professional posted a clarification on your forum topic.',
                'linked_entity_type' => ForumTopic::class,
                'linked_entity_id' => (string) $topic->getKey(),
            ]);
        }

        $this->log($request->user(), 'professional_clarify_forum_topic', ForumTopic::class, $topic->getKey(), 'Professional clarification posted.');

        return back()->with('status', 'Professional clarification posted.');
    }

    public function contactTopicAuthor(Request $request, ForumTopic $topic): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1200'],
        ]);

        if (! $topic->user_id) {
            return back()->withErrors(['message' => 'This topic is not linked to a registered user account.']);
        }

        Notification::create([
            'recipient_id' => $topic->user_id,
            'type' => 'forum_professional_contact',
            'message' => $data['message'],
            'linked_entity_type' => ForumTopic::class,
            'linked_entity_id' => (string) $topic->getKey(),
        ]);

        $this->log($request->user(), 'professional_contact_forum_author', ForumTopic::class, $topic->getKey(), 'Professional contacted forum author.');

        return back()->with('status', 'The user has been contacted through their notification inbox.');
    }

    private function validatedModerationData(Request $request): array
    {
        return $request->validate([
            'moderation_status' => ['required', 'string', 'in:needs_professional_review,reviewed,clarified'],
            'moderation_reason' => ['required', 'string', 'in:misinformation,unsafe_advice,private_info,needs_clarification,other'],
            'moderation_note' => ['nullable', 'string', 'max:2000'],
        ]);
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
            'private_info' => 'Private information exposed',
            'needs_clarification' => 'Needs professional clarification',
            'other' => 'Other',
        ];
    }
}
