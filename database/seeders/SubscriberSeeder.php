<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Brand;
use App\Models\Subscriber;
use Illuminate\Support\Arr;
class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $brand = Brand::pluck('id')->toArray();
        foreach($users as $userId){
            Subscriber::create([
                "user_id" => $userId,
                "brand_id" => Arr::random($brand)
            ]);  
        }
    }
}
