<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Audience;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Seed the application's comments.
     */
    public function run(): void
    {
        // Get users
        $sokUser = User::where('name', 'sok123')->first();
        $samnangUser = User::where('name', 'samnang')->first();
        $saoUser = User::where('name', 'sao')->first();

        // Get articles and authors
        $climateChanges = Article::where('title', 'Climate changes in the last 3 years')->first();
        $samnangAudience = Audience::where('name', 'Samnang')->first();

        // 1. Author Sok commented on his article "Climate changes in the last 3 years": "Thank you to all the subscribers"
        if ($sokUser && $climateChanges) {
            Comment::create([
                'content' => 'Thank you to all the subscribers',
                'commentable_type' => Article::class,
                'commentable_id' => $climateChanges->id,
                'user_id' => $sokUser->id,
            ]);
        }

        // 2. Audience Samnang commented on author Sao: "Your article is amazing"
        $saoAuthor = Author::where('name', 'Sao')->first();
        if ($samnangUser && $saoAuthor) {
            Comment::create([
                'content' => 'Your article is amazing',
                'commentable_type' => Author::class,
                'commentable_id' => $saoAuthor->id,
                'user_id' => $samnangUser->id,
            ]);
        }

        // 3. Author Sao commented on Audience Samnang: "Welcome to read my article"
        if ($saoUser && $samnangAudience) {
            Comment::create([
                'content' => 'Welcome to read my article',
                'commentable_type' => Audience::class,
                'commentable_id' => $samnangAudience->id,
                'user_id' => $saoUser->id,
            ]);
        }

        // 4. Audience Veasna commented on article "Quantum computers, is it coming?": "I can't wait this thing happening"
        $veasnaUser = User::where('name', 'veasna')->first();
        $quantumComputers = Article::where('title', 'Quantum computers, is it coming?')->first();
        if ($veasnaUser && $quantumComputers) {
            Comment::create([
                'content' => 'I can\'t wait this thing happening',
                'commentable_type' => Article::class,
                'commentable_id' => $quantumComputers->id,
                'user_id' => $veasnaUser->id,
            ]);
        }
    }
}