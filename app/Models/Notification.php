<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_id',
        'type',
        'message',
        'linked_entity_type',
        'linked_entity_id',
        'read',
    ];

    protected function casts(): array
    {
        return [
            'read' => 'boolean',
        ];
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function targetUrl(): string
    {
        if ($this->linked_entity_type === ConsultationRequest::class && $this->linked_entity_id) {
            $consultation = ConsultationRequest::find($this->linked_entity_id);

            if ($consultation) {
                return match ($this->recipient?->role) {
                    'admin' => route('admin.consultations.show', $consultation),
                    'professional' => route('professional.consultations.show', $consultation),
                    default => route('consultations.show', $consultation),
                };
            }
        }

        if ($this->linked_entity_type === ForumTopic::class && $this->linked_entity_id) {
            $topic = ForumTopic::find($this->linked_entity_id);

            if ($topic) {
                return match ($this->recipient?->role) {
                    'admin' => route('admin.forum.show', $topic),
                    'professional' => route('professional.forum.show', $topic),
                    default => route('forum.show', $topic),
                };
            }
        }

        return match ($this->recipient?->role) {
            'admin' => route('admin.dashboard'),
            'professional' => route('professional.dashboard'),
            default => route('dashboard'),
        };
    }

    public function title(): string
    {
        return Str::headline($this->type);
    }

    public function displayMessage(): string
    {
        if ($this->linked_entity_type !== ConsultationRequest::class || ! $this->linked_entity_id) {
            return $this->message;
        }

        if ($this->recipient?->role === 'professional') {
            return $this->message;
        }

        $consultation = ConsultationRequest::query()
            ->with('assignedProfessional')
            ->find($this->linked_entity_id);

        if (! $consultation) {
            return $this->message;
        }

        if (! $consultation->assignedProfessional) {
            return $this->message.' Assigned professional: Awaiting assignment.';
        }

        $professionalName = $consultation->assignedProfessional->display_name
            ?: $consultation->assignedProfessional->name;

        if ($consultation->assignedProfessional->professional_title) {
            $professionalName .= ' ('.$consultation->assignedProfessional->professional_title.')';
        }

        return $this->message.' Assigned professional: '.$professionalName.'.';
    }
}
