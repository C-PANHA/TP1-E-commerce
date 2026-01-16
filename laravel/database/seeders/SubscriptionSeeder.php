<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Audience;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Seed the application's subscriptions.
     */
    public function run(): void
    {
        // Get audiences
        $samnang = Audience::where('name', 'Samnang')->first();
        $veasna = Audience::where('name', 'Veasna')->first();
        $ratana = Audience::where('name', 'Ratana')->first();

        // Get articles
        $computersNextGen = Article::where('title', 'Computers in the next generation')->first();
        $chemistryNature = Article::where('title', 'Chemistry in nature form')->first();
        $originWater = Article::where('title', 'The origin of water')->first();
        $climateChanges = Article::where('title', 'Climate changes in the last 3 years')->first();
        $quantumComputers = Article::where('title', 'Quantum computers, is it coming?')->first();
        $globalWarming = Article::where('title', 'Global warming is in its critical stage')->first();

        // Samnang subscribes to: "Computers in the next generation", "Chemistry in nature form", "The origin of water"
        if ($samnang) {
            if ($computersNextGen) $samnang->articles()->attach($computersNextGen->id);
            if ($chemistryNature) $samnang->articles()->attach($chemistryNature->id);
            if ($originWater) $samnang->articles()->attach($originWater->id);
        }

        // Veasna subscribes to: "Climate changes in the last 3 years", "The origin of water", "Quantum computers, is it coming?"
        if ($veasna) {
            if ($climateChanges) $veasna->articles()->attach($climateChanges->id);
            if ($originWater) $veasna->articles()->attach($originWater->id);
            if ($quantumComputers) $veasna->articles()->attach($quantumComputers->id);
        }

        // Ratana subscribes to: "Climate changes in the last 3 years", "Global warming is in its critical stage"
        if ($ratana) {
            if ($climateChanges) $ratana->articles()->attach($climateChanges->id);
            if ($globalWarming) $ratana->articles()->attach($globalWarming->id);
        }
    }
}