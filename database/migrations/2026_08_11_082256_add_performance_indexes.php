<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Índices para as colunas efectivamente filtradas/agrupadas nos
     * relatórios (secção 44), no dashboard e nas listagens do admin.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->index('status');
            $table->index('modality');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->index('province');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->index('status');
            $table->index('category');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->index('status');
            $table->index('category');
        });

        Schema::table('checkins', function (Blueprint $table) {
            $table->index('checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['modality']);
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex(['province']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category']);
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category']);
        });

        Schema::table('checkins', function (Blueprint $table) {
            $table->dropIndex(['checked_in_at']);
        });
    }
};
