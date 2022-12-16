<?php

namespace App\Jobs;

use App\Models\logging;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class loggingFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user_id;
    protected $username;
    protected $file_id;
    protected $change;
    public function __construct($user_id,$username,$file_id,$change)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->file_id = $file_id;
        $this->change = $change;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = new logging();
        $log->user_id = $this->user_id;
        $log->username = $this->username;
        $log->file_id = $this->file_id;
        $log->change = $this->change;
        $log->save();
    }
}
