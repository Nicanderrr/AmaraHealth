<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'user_id',
        'subject',
        'concern_category',
        'concern_type',
        'symptoms',
        'questions',
        'questionnaire_responses',
        'urgency',
        'status',
        'response',
        'reviewed_by',
        'reviewed_at',
        'assigned_professional_id',
        'assigned_at',
        'recommendation',
        'status_history',
        'submitted_at',
        'responded_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'questionnaire_responses' => 'array',
            'recommendation' => 'array',
            'status_history' => 'array',
            'assigned_at' => 'datetime',
            'submitted_at' => 'datetime',
            'responded_at' => 'datetime',
            'closed_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function assignedProfessional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_professional_id');
    }

    public function callSessions(): HasMany
    {
        return $this->hasMany(ConsultationCallSession::class);
    }

    public function callRequests(): HasMany
    {
        return $this->hasMany(ConsultationCallRequest::class);
    }

    public function callRecordings(): HasMany
    {
        return $this->hasMany(ConsultationCallRecording::class);
    }

    public function getRouteKeyName(): string
    {
        return 'tracking_code';
    }
}
