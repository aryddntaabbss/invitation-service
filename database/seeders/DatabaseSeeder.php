<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'lomo9030@gmail.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create sample template
        \App\Models\Template::create([
            'name' => 'Template Elegant',
            'slug' => 'template-elegant',
            'description' => 'Template elegan untuk pernikahan',
            'preview_image' => 'templates/elegant-preview.jpg',
            'category' => 'wedding',
            'is_active' => true,
        ]);
    }
}
