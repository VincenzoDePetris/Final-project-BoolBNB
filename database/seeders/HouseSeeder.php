<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $houses = config('db.houses');

        $user_ids = User::all()->pluck('id')->toArray();

        foreach ($houses as $_house){

            
            $house = new House();
            $house->user_id = $faker->randomElement($user_ids);
            $house->title = $_house['title'];
            $house->address = $_house['address'];
            $house->latitude = $_house['latitude'];
            $house->longitude = $_house['longitude'];
            $house->beds = $_house['beds'];
            $house->rooms = $_house['rooms'];
            $house->bathrooms = $_house['bathrooms'];
            $house->sq_meters = $_house['sq_meters'];
            $house->description = $_house['description'];
            $house->cover_image = $_house['cover_image'];

            $house->save();
        }
    }
}