<?php

namespace App\Jobs;

use App\Models\AssignTodo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use PhpParser\Node\Expr\Assign;

class CheckEstimatedTime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->info("queue start");
        $data = AssignTodo::all();
        foreach($data as $key=>$val){
            if($val->completion_time < now()){
                Log::channel("queueLog")->info("Estimated time out for AssignTodo",['id'=>$val->id]);
            }
        }
        Log::channel("queueLog")->info("remaning job done on time",[]);
    }
}
