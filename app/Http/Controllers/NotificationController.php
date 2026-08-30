<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function open(Notification $notification, Request $request): RedirectResponse
    {
        abort_unless($notification->recipient_id === $request->user()->id, 403);

        if (! $notification->read) {
            $notification->update(['read' => true]);
        }

        return redirect($notification->load('recipient')->targetUrl());
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()
            ->notifications()
            ->where('read', false)
            ->update(['read' => true]);

        return back()->with('status', 'Notifications marked as read.');
    }
}
