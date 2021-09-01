<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(0,500) as $value){
            $faker = Faker\Factory::create();
            $name = $faker->firstName." ".$faker->lastName;
            $email = $faker->email;
            $password = Hash::make(Str::random(8));
            
            User::create([
                "name" => $name,
                "email" => $email,
                "password" => $password
            ]);
        }
    }
}
