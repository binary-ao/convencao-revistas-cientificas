<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_day_id')->constrained()->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', [
                'opening', 'keynote', 'panel', 'roundtable', 'workshop', 'course',
                'forum', 'break', 'lunch', 'debate', 'plenary', 'closing', 'other',
            ]);
            $table->string('room_location')->nullable();
            $table->enum('modality', ['presencial', 'online', 'hibrido'])->default('presencial');
            $table->foreignId('workshop_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('moderator_speaker_id')->nullable()->constrained('speakers')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_sessions');
    }
};
