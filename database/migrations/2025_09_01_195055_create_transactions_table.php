<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('invitation_id')->nullable()->constrained()->onDelete('set null');

            // Informasi transaksi
            $table->string('transaction_code')->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Status transaksi
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->enum('payment_method', ['bank_transfer', 'credit_card', 'e_wallet', 'qris', 'other'])->default('bank_transfer');
            $table->string('payment_channel')->nullable(); // BCA, BNI, Mandiri, etc.

            // Informasi pembayaran
            $table->string('payment_code')->nullable(); // Virtual account number, etc.
            $table->datetime('payment_expiry')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->text('payment_notes')->nullable();

            // Metadata
            $table->text('customer_notes')->nullable();
            $table->json('metadata')->nullable(); // Data tambahan dalam format JSON
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('customer_id');
            $table->index('package_id');
            $table->index('invitation_id');
            $table->index('transaction_code');
            $table->index('status');
            $table->index('payment_method');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
