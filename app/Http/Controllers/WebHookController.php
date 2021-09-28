<?php

namespace App\Http\Controllers;

use App\Events\TodoEvent;
use App\Http\Services\ExceptionLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebHookController extends Controller
{
    public function webHook(Request $request,ExceptionLog $errorLog){
        try{
            // dd("hello");
            if($request->type == "create"){
                $validator = Validator::make($request->all(), [
                    'data.name'=> 'required|string'
                ]);
            }
            if($request->type == "update"){
                $validator = Validator::make($request->all(), [
                    'id' => 'required|exists:todos,id',
                    'name'=> 'required|string'
                ]);
            }
            if($request->type == "delete"){
                $validator = Validator::make($request->all(), [
                    'id' => 'required|exists:todos,id',
                ]);
                
            }

            if ($validator->fails()) {
                Log::info($validator->errors());
                return response()->json(["status"=>false,"error"=>$validator->errors()]);
            }
            // dd($request->all());
            TodoEvent::dispatch($request->all());
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $res = $errorLog->ExceptionLogCreate($e,$errorData);
            return response()->json($res);
        }
    }
}
