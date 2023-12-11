<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = config('db.sponsorships');

        foreach ($sponsorships as $_sponsorships){

            
            $sponsorships = new Sponsorship();
            $sponsorships->price = $_sponsorships['price'];
            $sponsorships->duration = $_sponsorships['duration'];
            $sponsorships->name = $_sponsorships['name'];

            $sponsorships->save();
        }
    }
}