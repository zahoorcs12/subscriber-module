<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\EmailLog;

class EmailLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts= Post::with([
            'brand','brand.subscribers'
        ])->get();
        if(!empty($posts)){
            foreach($posts as $post){
                if(isset($post->brand->subscribers) && !empty($post->brand->subscribers)){
                    foreach($post->brand->subscribers as $subscriber){
                        EmailLog::create([
                            "post_id" => $post->id,
                            "subscriber_id" => $subscriber->id,
                            "status_id" => 1
                        ]);
                    }
                }else{
                    continue;
                }
            }
        }
    }
}
