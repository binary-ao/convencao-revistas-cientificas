<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('long_description')->nullable();

            // Data e local — nulos até serem definidos, nunca inventados
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->enum('format', ['presencial', 'online', 'hibrido'])->default('presencial');

            // Contacto e presença online
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('website_url')->nullable();

            // Identidade visual
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('cover_image_path')->nullable();

            // Inscrições
            $table->boolean('registration_open')->default(false);
            $table->dateTime('registration_opens_at')->nullable();
            $table->dateTime('registration_closes_at')->nullable();
            $table->unsignedInteger('participant_limit')->nullable();

            // Ciclo de vida editorial
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_current')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
