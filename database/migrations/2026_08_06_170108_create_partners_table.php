<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('website_url')->nullable();
            $table->enum('category', [
                'ciencia_politica', 'edicao_indexacao', 'ciencia_aberta', 'africa_lusofonia',
            ]);
            $table->enum('status', ['proposto', 'convidado', 'confirmado', 'recusou'])->default('proposto');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
