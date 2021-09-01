<?php

namespace Database\Seeders;

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
            BrandSeeder::class,
            UserSeeder::class,
            SubscriberSeeder::class,
            PostSeeder::class,
            EmailStatusSeeder::class,
            EmailLogsSeeder::class
        ]);
    }
}
