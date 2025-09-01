<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onDelete('cascade');

            // Basic information
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->text('groom_bio')->nullable();
            $table->text('bride_bio')->nullable();
            $table->string('groom_parents')->nullable();
            $table->string('bride_parents')->nullable();

            // Event information
            $table->datetime('event_date');
            $table->time('event_time');
            $table->text('event_address');
            $table->text('google_maps_link')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Customization
            $table->string('primary_color')->default('#4F46E5');
            $table->string('secondary_color')->default('#EC4899');
            $table->string('font_family')->default('Inter');
            $table->string('music_url')->nullable();
            $table->string('custom_domain')->nullable();
            $table->string('password')->nullable(); // password untuk akses undangan

            // Status & Settings
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            $table->datetime('published_at')->nullable();
            $table->datetime('expires_at');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('is_active');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
