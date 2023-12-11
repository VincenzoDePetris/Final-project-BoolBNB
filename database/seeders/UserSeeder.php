<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('db.users');

        foreach ($users as $_user){

            
            $user = new User();
            $user->name = $_user['name'];
            $user->last_name = $_user['last_name'];
            $user->email = $_user['email'];
            $user->date_of_birth = $_user['date_of_birth'];
            $user->password = Hash::make($_user['password']);

            $user->save();
        }
    }
}