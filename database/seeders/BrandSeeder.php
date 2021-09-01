<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Faker;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
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
            $brandName = $faker->company;
            $domain = "https://www.";
            $domain .=Str::slug($brandName).".com";
            $logo = Str::slug($brandName).".png"; 
            Brand::create([
                "name" => $brandName,
                "url" => $domain,
                "logo" => $logo
            ]);
            $domain = null;
        }
    }
}
