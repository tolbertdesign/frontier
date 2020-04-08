<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SomeJob implements ShouldQueue
{
    protected $user;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(4);
        $message = 'SomeJob was completed!';
        Log::emergency('Emergency' . ': ' . $message);
        Log::Alert('Alert' . ': ' . $message);
        Log::Critical('Critical' . ': ' . $message);
        Log::Error('Error' . ': ' . $message);
        Log::Warning('Warning' . ': ' . $message);
        Log::Notice('Notice' . ': ' . $message);
        Log::Info('Info' . ': ' . $message);
        Log::debug('Debug' . ': ' . $message);
    }
}
