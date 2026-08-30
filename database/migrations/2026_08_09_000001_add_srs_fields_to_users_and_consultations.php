<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id', 16)->nullable()->unique()->after('email');
            $table->string('display_name')->nullable()->after('name');
            $table->string('account_status')->default('active')->after('role');
            $table->string('professional_title')->nullable()->after('account_status');
            $table->json('assigned_categories')->nullable()->after('professional_title');
            $table->string('university_email')->nullable()->after('assigned_categories');
            $table->string('availability')->default('available')->after('university_email');
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
            $table->string('student_id_hash', 64)->nullable()->after('last_login_at');
        });

        Schema::table('consultation_requests', function (Blueprint $table) {
            $table->string('concern_category')->nullable()->after('subject');
            $table->json('questionnaire_responses')->nullable()->after('questions');
            $table->foreignId('assigned_professional_id')->nullable()->after('reviewed_by')->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable()->after('assigned_professional_id');
            $table->json('recommendation')->nullable()->after('assigned_at');
            $table->json('status_history')->nullable()->after('recommendation');
            $table->timestamp('submitted_at')->nullable()->after('status_history');
            $table->timestamp('responded_at')->nullable()->after('submitted_at');
            $table->timestamp('closed_at')->nullable()->after('responded_at');
        });

        Schema::table('health_articles', function (Blueprint $table) {
            $table->string('status')->default('approved')->after('is_featured');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->string('author_title')->nullable()->after('author_id');
            $table->string('author_display_name')->nullable()->after('author_title');
        });
    }

    public function down(): void
    {
        Schema::table('consultation_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_professional_id');
            $table->dropColumn([
                'concern_category',
                'questionnaire_responses',
                'assigned_at',
                'recommendation',
                'status_history',
                'submitted_at',
                'responded_at',
                'closed_at',
            ]);
        });

        Schema::table('health_articles', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'author_title', 'author_display_name']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'student_id',
                'display_name',
                'account_status',
                'professional_title',
                'assigned_categories',
                'university_email',
                'availability',
                'last_login_at',
                'student_id_hash',
            ]);
        });
    }
};
