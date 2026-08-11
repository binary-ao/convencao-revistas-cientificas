<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_speakers', function (Blueprint $table) {
            $table->foreignId('event_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->enum('role_in_session', ['palestrante', 'moderador', 'formador', 'convidado'])->default('palestrante');
            $table->timestamps();

            $table->primary(['event_session_id', 'speaker_id', 'role_in_session']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_speakers');
    }
};
