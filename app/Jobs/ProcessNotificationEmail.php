<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;
use App\Models\Post;

class ProcessNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($logId)
    {
        $this->logId = $logId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailConent = $this->mailContent();
        if(!empty($mailConent)){
            Mail::send([], [], function ($message) use($mailConent) {
                $message->to($mailConent['to'])
                  ->subject($mailConent['subject'])
                  ->setBody($mailConent['content'], 'text/html'); // for HTML rich messages
              });
        }
        EmailLog::where('id',$this->logId)->update([
            "status_id" => 2
        ]);
    }

    public function mailContent()
    {
        $response = [];
        $logData = EmailLog::with(['post', 'subscriber', 'subscriber.user', 'post.brand'])->where('id', $this->logId)->first();
        if (!empty($logData) && isset($logData->post) && !empty($logData->post) && isset($logData->subscriber->user) && !empty($logData->subscriber->user) && isset($logData->post->brand) && !empty($logData->post->brand)) {
            $content = '<h1>Hi, '.$logData->subscriber->user->name.'!</h1>';
            $content .= '<br><h2>Post Title:'.$logData->post->title.'</h2>';
            $content .= '<br><p><b>Post Description</b>:'.$logData->post->description.'</p>';
            $content .= '<br><p><b>Brand Name / Website</b>:'.$logData->post->brand->name.'</p>';
            $content .= '<br><p>Thanks !</p>';
           $response = [
               "to" => $logData->subscriber->user->email,
               "subject" => "Hello ".$logData->subscriber->user->name." from ".$logData->post->brand->name,
               "content" => $content
           ];
        }else{
            EmailLog::where('id',$this->logId)->update([
                "status_id" => 5
            ]);
        }

        return $response;
        
    }
}
