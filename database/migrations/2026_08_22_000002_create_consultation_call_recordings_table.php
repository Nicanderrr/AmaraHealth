<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('consultation_call_recordings')) {
            DB::statement(
                'ALTER TABLE consultation_call_recordings
                ADD CONSTRAINT call_recordings_session_fk
                FOREIGN KEY (consultation_call_session_id)
                REFERENCES consultation_call_sessions(id)
                ON DELETE CASCADE'
            );

            return;
        }

        Schema::create('consultation_call_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_request_id');
            $table->foreignId('consultation_call_session_id');
            $table->string('provider')->default('pending');
            $table->string('provider_recording_id')->nullable();
            $table->string('storage_path')->nullable();
            $table->string('status')->default('scheduled');
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('available_at')->nullable();
            $table->timestamp('delete_after')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->index('provider_recording_id', 'call_recordings_provider_recording_id_idx');
            $table->foreign('consultation_request_id', 'call_recordings_request_fk')
                ->references('id')
                ->on('consultation_requests')
                ->cascadeOnDelete();
            $table->foreign('consultation_call_session_id', 'call_recordings_session_fk')
                ->references('id')
                ->on('consultation_call_sessions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_call_recordings');
    }
};
