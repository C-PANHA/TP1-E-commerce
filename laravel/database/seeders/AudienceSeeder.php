<?php

namespace Database\Seeders;

use App\Models\Audience;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AudienceSeeder extends Seeder
{
    /**
     * Seed the application's audiences.
     */
    public function run(): void
    {
        // Create audience Veasna with user veasna
        $userVeasna = User::create([
            'name' => 'veasna',
            'email' => 'veasna@example.com',
            'password' => Hash::make('password123'),
        ]);

        Audience::create([
            'name' => 'Veasna',
            'description' => 'Audience Veasna',
            'user_id' => $userVeasna->id,
        ]);

        // Create audience Samnang with user samnang
        $userSamnang = User::create([
            'name' => 'samnang',
            'email' => 'samnang@example.com',
            'password' => Hash::make('password123'),
        ]);

        Audience::create([
            'name' => 'Samnang',
            'description' => 'Audience Samnang',
            'user_id' => $userSamnang->id,
        ]);

        // Create audience Ratana with user ratana
        $userRatana = User::create([
            'name' => 'ratana',
            'email' => 'ratana@example.com',
            'password' => Hash::make('password123'),
        ]);

        Audience::create([
            'name' => 'Ratana',
            'description' => 'Audience Ratana',
            'user_id' => $userRatana->id,
        ]);
    }
}