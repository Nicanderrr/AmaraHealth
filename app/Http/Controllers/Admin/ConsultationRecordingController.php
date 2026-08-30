<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ConsultationCallRecording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConsultationRecordingController extends Controller
{
    public function show(ConsultationCallRecording $recording, Request $request): StreamedResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);
        abort_if($recording->deleted_at, 404);
        abort_unless($recording->storage_path && Storage::disk('local')->exists($recording->storage_path), 404);

        AuditLog::create([
            'admin_id' => $request->user()->id,
            'action' => 'view_call_recording',
            'target_entity_type' => ConsultationCallRecording::class,
            'target_entity_id' => (string) $recording->getKey(),
            'reason' => 'Admin opened a recorded consultation call.',
        ]);

        return Storage::disk('local')->response($recording->storage_path);
    }
}
