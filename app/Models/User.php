<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'display_name',
        'profile_photo_path',
        'account_status',
        'professional_title',
        'assigned_categories',
        'university_email',
        'availability',
        'last_login_at',
        'student_id_hash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'assigned_categories' => 'array',
            'password' => 'hashed',
        ];
    }

    public function healthArticles(): HasMany
    {
        return $this->hasMany(HealthArticle::class, 'author_id');
    }

    public function cycleEntries(): HasMany
    {
        return $this->hasMany(CycleEntry::class);
    }

    public function forumTopics(): HasMany
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function forumReplies(): HasMany
    {
        return $this->hasMany(ForumReply::class);
    }

    public function consultationRequests(): HasMany
    {
        return $this->hasMany(ConsultationRequest::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'recipient_id');
    }

    public function studentCallSessions(): HasMany
    {
        return $this->hasMany(ConsultationCallSession::class, 'student_id');
    }

    public function studentCallRequests(): HasMany
    {
        return $this->hasMany(ConsultationCallRequest::class, 'student_id');
    }

    public function professionalCallRequests(): HasMany
    {
        return $this->hasMany(ConsultationCallRequest::class, 'professional_id');
    }

    public function professionalCallSessions(): HasMany
    {
        return $this->hasMany(ConsultationCallSession::class, 'professional_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProfessional(): bool
    {
        return $this->role === 'professional';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isSuspended(): bool
    {
        return $this->account_status === 'suspended';
    }
}
