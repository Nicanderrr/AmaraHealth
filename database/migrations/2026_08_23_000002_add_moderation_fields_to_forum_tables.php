<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->string('moderation_status')->default('none')->after('is_locked');
            $table->string('moderation_reason')->nullable()->after('moderation_status');
            $table->text('moderation_note')->nullable()->after('moderation_reason');
            $table->foreignId('moderated_by_id')->nullable()->after('moderation_note')->constrained('users')->nullOnDelete();
            $table->timestamp('moderated_at')->nullable()->after('moderated_by_id');
            $table->boolean('is_hidden')->default(false)->after('moderated_at');
        });

        Schema::table('forum_replies', function (Blueprint $table) {
            $table->string('moderation_status')->default('none')->after('body');
            $table->string('moderation_reason')->nullable()->after('moderation_status');
            $table->text('moderation_note')->nullable()->after('moderation_reason');
            $table->foreignId('moderated_by_id')->nullable()->after('moderation_note')->constrained('users')->nullOnDelete();
            $table->timestamp('moderated_at')->nullable()->after('moderated_by_id');
            $table->boolean('is_hidden')->default(false)->after('moderated_at');
            $table->boolean('is_professional_clarification')->default(false)->after('is_hidden');
        });
    }

    public function down(): void
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropForeign(['moderated_by_id']);
            $table->dropColumn([
                'moderation_status',
                'moderation_reason',
                'moderation_note',
                'moderated_by_id',
                'moderated_at',
                'is_hidden',
                'is_professional_clarification',
            ]);
        });

        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropForeign(['moderated_by_id']);
            $table->dropColumn([
                'moderation_status',
                'moderation_reason',
                'moderation_note',
                'moderated_by_id',
                'moderated_at',
                'is_hidden',
            ]);
        });
    }
};
