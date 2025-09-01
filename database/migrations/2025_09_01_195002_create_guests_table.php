<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('number_of_guests')->default(1);
            $table->boolean('is_confirmed')->default(false);
            $table->datetime('confirmed_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('attendance_status')->default('pending'); // pending, attending, not_attending
            $table->text('custom_message')->nullable();
            $table->string('token')->unique()->nullable(); // token untuk konfirmasi kehadiran
            $table->timestamps();

            // Indexes
            $table->index('invitation_id');
            $table->index('email');
            $table->index('phone');
            $table->index('is_confirmed');
            $table->index('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
