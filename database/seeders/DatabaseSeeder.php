<?php

namespace Database\Seeders;

use App\Models\SponsoredHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            HouseSeeder::class,
            ExtraSeeder::class,
            SponsorshipSeeder::class,
        ]);
    }
}