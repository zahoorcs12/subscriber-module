<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailLog;
use App\Jobs\ProcessNotificationEmail;

class SendPostNotificaitonEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendpostnotification:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send post notification emails to brand subscriber against new post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       //mark new pending post to queue for send emial notification 
       $pendingLogs = EmailLog::with([
           "subscriber","subscriber.user"
       ])->take(10)->where('status_id',1)->get();
       if(!empty($pendingLogs)){
           foreach($pendingLogs as $pendingLog){
                //mark log as processed in queue
                ProcessNotificationEmail::dispatch($pendingLog->id);
                $pendingLog->status_id = 3;
                $pendingLog->save();
           }
       }   
    }
}
