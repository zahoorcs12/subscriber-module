<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailStatus;

class EmailStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createStatus = EmailStatus::create([
            "name" => "Pending"
        ]);
        $createStatus = EmailStatus::create([
            "name" => "Sent Successfully"
        ]);

        $createStatus = EmailStatus::create([
            "name" => "In Queue"
        ]);
        $createStatus = EmailStatus::create([
            "name" => "Bounced"
        ]);
        $createStatus = EmailStatus::create([
            "name" => "Failed"
        ]);
        
    }
}
