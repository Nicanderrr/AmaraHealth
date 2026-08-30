<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anonymous_name',
        'title',
        'body',
        'is_locked',
        'moderation_status',
        'moderation_reason',
        'moderation_note',
        'moderated_by_id',
        'moderated_at',
        'is_hidden',
        'last_reply_at',
    ];

    protected function casts(): array
    {
        return [
            'is_locked' => 'boolean',
            'is_hidden' => 'boolean',
            'last_reply_at' => 'datetime',
            'moderated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class)->latest();
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by_id');
    }
}
