<?php

namespace App\Console\Commands;

use App\Jobs\CheckEstimatedTime;
use Illuminate\Console\Command;

class TodoEstimatedTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Todo check estimated queue invoke command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("start");
        CheckEstimatedTime::dispatch();
        $this->info("end");
        return 0;
    }
}
