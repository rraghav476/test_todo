<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:user {--operation=} {--id=}{--name=} {--email=} {--password=} {--verified=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'operation c for create a new user;operation l for list of user;';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option("operation") == "c"){
            if(!$this->option("name") || !$this->option("email")){
                $this->info("email and name is required");
                return 0;
            }
            $password = $this->option("password")? $this->option("password"):Str::random(6);
            $pass = Hash::make($password);
            $data = [
                "name"=>$this->option("name"),
                "email"=>$this->option("email"),
                "password"=>$pass,
                "email_verified_at"=>$this->option("verified")?now():null,
                "role"=>2
            ];
            // $name = $this->argument("");
            User::create($data);
            $this->info("user create successfully email:".$data["email"]." password: ".$password);
            return 0;
        }

        if($this->option("operation") == "l"){
            
            $header = ["id","name","email"];
            $data =User::select("id","name","email")->get();
            $this->table($header,$data,$tableStyle="default");
            return 0;
        }

        if($this->option("operation") == "d"){
            if(!$this->option("id")){
                $this->info("enter id to delete a user");
                return 0;
            }
            $data =User::find($this->option("id"));
            if(!$data){
                $this->info("user not found or it's deleted");
                return;
            }
            $data->delete();
            $this->info("id:".$this->option("id")."user deleted");
            return 0;
        }
        $this->info("Please select a operation c for create,l for list,d for delete.for ex:--operation=l");
        return 0;
    }
}
