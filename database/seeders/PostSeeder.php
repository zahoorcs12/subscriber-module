<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\Brand;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::pluck('id')->toArray();
        $faker = Faker\Factory::create();
        foreach($brands as $brand){
            Post::create([
                "title" => $faker->name,
                "description" => $faker->text(250),
                "content" => $faker->text(500),
                "brand_id" => $brand,
            ]);
        }
    }
}
