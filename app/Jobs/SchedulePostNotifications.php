<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailLog;
use App\Models\Post;

class SchedulePostNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $postId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $post= Post::with([
            'brand','brand.subscribers'
        ])->where('id',$this->postId)->first();
        if(!empty($post)){
            
            if(isset($post->brand->subscribers) && !empty($post->brand->subscribers)){
                foreach($post->brand->subscribers as $subscriber){
                    EmailLog::create([
                        "post_id" => $post->id,
                        "subscriber_id" => $subscriber->id,
                        "status_id" => 1 //pending waiting for attempt
                    ]);
                }
            }
            
        }
    }


    
}
