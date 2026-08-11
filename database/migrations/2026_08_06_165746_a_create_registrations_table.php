<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();

            $table->string('code')->unique();
            $table->enum('status', ['draft', 'pending', 'confirmed', 'cancelled'])->default('pending');
            $table->enum('modality', ['presencial', 'online']);

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();

            // Preparado para integração futura — sem checkout nem gateway (secção 7 do Termo).
            $table->enum('payment_status', ['pending', 'not_required', 'awaiting_payment', 'paid', 'failed', 'cancelled'])
                ->default('not_required');
            $table->string('payment_reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string('pdf_path')->nullable();
            $table->timestamp('pdf_generated_at')->nullable();
            $table->string('qr_code_value')->nullable();

            $table->enum('checkin_status', ['not_checked_in', 'checked_in'])->default('not_checked_in');
            $table->enum('certificate_status', ['not_issued', 'issued'])->default('not_issued');

            $table->enum('source', ['web', 'admin'])->default('web');
            $table->text('admin_notes')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->ipAddress('ip_address')->nullable();

            $table->timestamps();

            $table->unique(['event_id', 'participant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
