<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Console\Command;

class TodoListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:list {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'return all todos with role or --id give todo create by someone';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id =$this->option("id")?? null;
        if($id){
            $headers=["id","name","created_by"];
            $user = User::find($id);
            $data = Todo::select("id","name","created_by")->where('created_by',$id)->get();
            $this->info($user->name." list of todos");
            $this->table($headers,$data,$tableStyle="default");
        }
        else{
            $headers=["id","name","created_by"];
            $data = Todo::select("id","name","created_by")->get();
            $this->info("user list");
            $this->table($headers,$data,$tableStyle="default");
        }
    }
}
