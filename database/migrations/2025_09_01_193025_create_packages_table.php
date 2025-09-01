<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->integer('duration_days');
            $table->integer('max_guests')->default(0); // 0 = unlimited
            $table->integer('max_photos')->default(10);
            $table->boolean('custom_domain')->default(false);
            $table->boolean('premium_support')->default(false);
            $table->boolean('background_music')->default(true);
            $table->boolean('photo_gallery')->default(true);
            $table->boolean('guest_book')->default(true);
            $table->boolean('countdown_timer')->default(true);
            $table->boolean('google_maps')->default(true);
            $table->boolean('qr_code')->default(true);
            $table->integer('template_access')->default(3); // jumlah template yang bisa diakses
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable(); // fitur tambahan dalam format JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
