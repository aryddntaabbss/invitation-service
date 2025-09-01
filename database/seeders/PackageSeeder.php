<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket Basic',
                'slug' => 'paket-basic',
                'description' => 'Paket dasar untuk undangan sederhana',
                'price' => 99000,
                'duration_days' => 30,
                'max_guests' => 100,
                'max_photos' => 10,
                'custom_domain' => false,
                'premium_support' => false,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Premium',
                'slug' => 'paket-premium',
                'description' => 'Paket premium dengan fitur lengkap',
                'price' => 199000,
                'duration_days' => 60,
                'max_guests' => 500,
                'max_photos' => 30,
                'custom_domain' => true,
                'premium_support' => true,
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Enterprise',
                'slug' => 'paket-enterprise',
                'description' => 'Paket enterprise untuk kebutuhan khusus',
                'price' => 399000,
                'duration_days' => 90,
                'max_guests' => 0, // unlimited
                'max_photos' => 100,
                'custom_domain' => true,
                'premium_support' => true,
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('packages')->insert($packages);
    }
}
