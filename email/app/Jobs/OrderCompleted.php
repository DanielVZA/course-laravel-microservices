<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump("Sending emails");

        \Mail::send('admin', ['order' => $this->data], function (Message $message) {
            $message->subject('An Order has been completed');
            $message->to('admin@admin.com');
        });

        \Mail::send('ambassador', ['order' => $this->data], function (Message $message) {
            $message->subject('An Order has been completed');
            $message->to($this->data['ambassador_email']);
        });

        var_dump("Email sent");
    }
}
