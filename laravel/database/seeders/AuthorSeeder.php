<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    /**
     * Seed the application's authors.
     */
    public function run(): void
    {
        // Create author Sok with user sok123
        $userSok = User::create([
            'name' => 'sok123',
            'email' => 'sok@example.com', // Assuming email, since not specified
            'password' => Hash::make('password123'), // Default password
        ]);

        Author::create([
            'name' => 'Sok',
            'email' => 'sok@example.com',
            'bio' => 'Author Sok bio',
            'user_id' => $userSok->id,
        ]);

        // Create author Sao with user sao
        $userSao = User::create([
            'name' => 'sao',
            'email' => 'sao@example.com',
            'password' => Hash::make('password123'),
        ]);

        Author::create([
            'name' => 'Sao',
            'email' => 'sao@example.com',
            'bio' => 'Author Sao bio',
            'user_id' => $userSao->id,
        ]);

        // Create author Dara with user d.dara
        $userDara = User::create([
            'name' => 'd.dara',
            'email' => 'dara@example.com',
            'password' => Hash::make('password123'),
        ]);

        Author::create([
            'name' => 'Dara',
            'email' => 'dara@example.com',
            'bio' => 'Author Dara bio',
            'user_id' => $userDara->id,
        ]);
    }
}