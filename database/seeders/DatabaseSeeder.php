<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            CitySeeder::class,
            ArticleSeeder::class, // SEO artikel 1500+ kata
            KecamatanAndScheduleSeeder::class,
        ]);
    }
}
