<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_topic_id',
        'user_id',
        'anonymous_name',
        'body',
        'moderation_status',
        'moderation_reason',
        'moderation_note',
        'moderated_by_id',
        'moderated_at',
        'is_hidden',
        'is_professional_clarification',
    ];

    protected function casts(): array
    {
        return [
            'moderated_at' => 'datetime',
            'is_hidden' => 'boolean',
            'is_professional_clarification' => 'boolean',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ForumTopic::class, 'forum_topic_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by_id');
    }
}
