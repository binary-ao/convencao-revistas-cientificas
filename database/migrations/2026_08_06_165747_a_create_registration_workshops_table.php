<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['registered', 'waitlisted', 'cancelled'])->default('registered');
            $table->timestamps();

            $table->unique(['registration_id', 'workshop_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_workshops');
    }
};
