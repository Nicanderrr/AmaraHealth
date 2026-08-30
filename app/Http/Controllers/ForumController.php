<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(): View
    {
        return view('forum.index', [
            'topics' => ForumTopic::query()
                ->where('is_hidden', false)
                ->withCount('replies')
                ->latest('last_reply_at')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('forum.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'anonymous_name' => ['nullable', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $topic = ForumTopic::create([
            'user_id' => Auth::id(),
            'anonymous_name' => trim($data['anonymous_name'] ?? '') ?: 'Anonymous',
            'title' => $data['title'],
            'body' => $data['body'],
            'is_locked' => false,
            'last_reply_at' => now(),
        ]);

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(function (User $admin) use ($topic) {
                Notification::create([
                    'recipient_id' => $admin->id,
                    'type' => 'forum_topic_created',
                    'message' => 'A new anonymous forum topic was posted.',
                    'linked_entity_type' => ForumTopic::class,
                    'linked_entity_id' => (string) $topic->getKey(),
                ]);
            });

        return redirect()
            ->route('forum.show', $topic)
            ->with('status', 'Your anonymous post is now live.');
    }

    public function show(ForumTopic $forum): View
    {
        abort_if($forum->is_hidden, 404);

        $forum->load(['replies' => fn ($query) => $query->where('is_hidden', false), 'replies.user']);

        return view('forum.show', [
            'topic' => $forum,
        ]);
    }

    public function reply(Request $request, ForumTopic $forum): RedirectResponse
    {
        if ($forum->is_locked) {
            return back()->withErrors(['body' => 'This discussion is locked.']);
        }

        $data = $request->validate([
            'anonymous_name' => ['nullable', 'string', 'max:80'],
            'body' => ['required', 'string', 'max:3000'],
        ]);

        $reply = $forum->replies()->create([
            'user_id' => Auth::id(),
            'anonymous_name' => trim($data['anonymous_name'] ?? '') ?: 'Anonymous',
            'body' => $data['body'],
            'is_professional_clarification' => $request->user()?->isProfessional() ?? false,
        ]);

        $forum->update(['last_reply_at' => now()]);

        if ($forum->user_id && $forum->user_id !== $reply->user_id) {
            Notification::create([
                'recipient_id' => $forum->user_id,
                'type' => 'forum_reply_created',
                'message' => 'Someone replied to your anonymous forum topic.',
                'linked_entity_type' => ForumTopic::class,
                'linked_entity_id' => (string) $forum->getKey(),
            ]);
        }

        return back()->with('status', 'Reply posted.');
    }
}
