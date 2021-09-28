<?php

namespace App\Http\Middleware;

use App\Models\Webhook;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebhookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return $next($request);
        try{
            $token = $request->header()["key"][0];
            $authtoken = new Webhook();
            // dd($authtoken);
            $check = $authtoken->where('key',$token)->get();
            // dd($check);
            if(count($check) == 0){
                return response()->json(["status"=>false,"error"=>"Access denied"],401);
            }
            Auth::loginUsingId($check[0]->admin_id);
            return $next($request);
        }catch(\Throwable $e){
            $log = [
                'file'=>__File__,
                'line'=>__LINE__,
                'function'=>__FUNCTION__,
                'msg' => $e->getMessage(),
                'error_code' => 'MAV-01',
            ];

            Log::error($log);
            
            $res = [
                'status' => false,
                'error' =>'something went wrong.Try again',
                'error_code'=>'MAV-01'
            ];

            if(env('APP_DEBUG') === true){
                $res['error'] = $e->getMessage();
            }

            if($e->getMessage() =="Undefined index: key"){
                return response()->json(["status"=>false,"error"=>"please check key"],401);
            }
            if($e->getCode() ==2002){
                return response()->json(["status"=>false,"error"=>"something went wrong."],503);
            }
                
            return response()->json($res);
        }
    }
}
