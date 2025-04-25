<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class MailQueue implements ShouldQueue
{
    use Queueable;

    public $is_done=false;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $email)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Mail sent to".$this->email);

        $this->is_done=true;
    }
}
