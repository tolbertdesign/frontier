<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\User;
use App\Libraries\MercuryNotification;

class CreateMercuryTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mercury:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a test notification to the specified mail address';

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
     * @return mixed
     */
    public function handle()
    {
        $user        = User::where('email', $this->argument('email'))->first();
        $data        = (object)[];
        $data->users = [$user];
        MercuryNotification::dispatch($data, 'TestEvent');
    }
}
