<?php

namespace App\Listeners;

use App\Events\TodoEvent;
use App\Models\Todo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TodoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TodoEvent  $event
     * @return void
     */
    public function handle(TodoEvent $event)
    {
        // dd($event->request["type"]);
        $request = $event->request;
        // Log::info($event);
        if($request["type"] == "create"){
            // dd($request["type"],["name"=>$request["data"]["name"],"created_by"=>Auth::user()->id]);
            Todo::create(["name"=>$request["data"]["name"],"created_by"=>Auth::user()->id]);

        }

        if($request["type"] == "update"){
            $todoUpdate = Todo::find($request["id"]);
            if(!$todoUpdate->count()){
                Log::info("todo not found id ".$request["id"]);
            }
            $todoUpdate->name = $request["data"]["name"];
            $todoUpdate->save();
            Log::info("todo update successfully id:".$request["id"]);
        }

        if($request["type"] == "delete"){
            $todoUpdate = Todo::find($request["id"]);
            if(!$todoUpdate->count()){
                Log::info("todo not found or deleted id ".$request["id"]);
            }
            $todoUpdate->delete();
        }
    }
}
