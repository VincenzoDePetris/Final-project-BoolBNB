<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\HouseSponsorship;
use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class HouseSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        $house_ids = House::all()->pluck('id')->toArray();
        $sponsorship_ids = Sponsorship::all()->pluck('id')->toArray();
        
        for($i = 0; $i < 30; $i++){
            $houseSponsored = new HouseSponsorship();
            $houseSponsored->house_id = $faker->randomElement($house_ids);
            $houseSponsored->sponsorship_id = $faker->randomElement($sponsorship_ids);

            $houseSponsored->save();

        }
    }
}
