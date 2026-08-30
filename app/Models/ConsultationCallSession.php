<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConsultationCallSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_request_id',
        'student_id',
        'professional_id',
        'provider',
        'room_name',
        'join_url',
        'scheduled_at',
        'started_at',
        'ended_at',
        'status',
        'recording_enabled',
        'student_consented_at',
        'professional_consented_at',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'recording_enabled' => 'boolean',
            'student_consented_at' => 'datetime',
            'professional_consented_at' => 'datetime',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function recording(): HasOne
    {
        return $this->hasOne(ConsultationCallRecording::class);
    }
}
