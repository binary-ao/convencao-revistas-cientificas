<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('province')->nullable();
            $table->string('country')->nullable();

            $table->foreignId('institution_id')->nullable()->constrained()->nullOnDelete();
            $table->string('institution_name_other')->nullable();
            $table->string('job_title')->nullable();
            $table->string('scientific_area')->nullable();

            $table->foreignId('participant_type_id')->constrained();
            $table->string('participant_type_other')->nullable();

            $table->timestamp('privacy_policy_accepted_at')->nullable();
            $table->timestamps();

            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
