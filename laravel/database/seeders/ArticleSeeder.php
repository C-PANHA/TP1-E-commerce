<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Seed the application's articles.
     */
    public function run(): void
    {
        // Get authors
        $sok = Author::where('name', 'Sok')->first();
        $sao = Author::where('name', 'Sao')->first();
        $dara = Author::where('name', 'Dara')->first();

        if ($sok) {
            Article::create([
                'title' => 'Climate changes in the last 3 years',
                'content' => 'Content about climate changes...',
                'author_id' => $sok->id,
                'published_at' => now(),
            ]);

            Article::create([
                'title' => 'Global warming is in its critical stage',
                'content' => 'Content about global warming...',
                'author_id' => $sok->id,
                'published_at' => now(),
            ]);
        }

        if ($sao) {
            Article::create([
                'title' => 'Computers in the next generation',
                'content' => 'Content about next generation computers...',
                'author_id' => $sao->id,
                'published_at' => now(),
            ]);

            Article::create([
                'title' => 'Quantum computers, is it coming?',
                'content' => 'Content about quantum computers...',
                'author_id' => $sao->id,
                'published_at' => now(),
            ]);
        }

        if ($dara) {
            Article::create([
                'title' => 'Chemistry in nature form',
                'content' => 'Content about chemistry in nature...',
                'author_id' => $dara->id,
                'published_at' => now(),
            ]);

            Article::create([
                'title' => 'The origin of water',
                'content' => 'Content about the origin of water...',
                'author_id' => $dara->id,
                'published_at' => now(),
            ]);
        }
    }
}