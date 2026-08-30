<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationCallRecording extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_request_id',
        'consultation_call_session_id',
        'provider',
        'provider_recording_id',
        'storage_path',
        'status',
        'duration_seconds',
        'started_at',
        'ended_at',
        'available_at',
        'delete_after',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'available_at' => 'datetime',
            'delete_after' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ConsultationCallSession::class, 'consultation_call_session_id');
    }
}
