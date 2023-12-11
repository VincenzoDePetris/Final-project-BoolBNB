<?php

namespace Database\Seeders;

use App\Models\Extra;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $extras = config('db.extras');

        foreach ($extras as $_extra){

            
            $extra = new Extra();
            $extra->name = $_extra['name'];
            $extra->color = $_extra['color'];
            $extra->icon = $_extra['icon'];
            $extra->icon_vue = $_extra['icon_vue'];

            $extra->save();
        }
    }
}