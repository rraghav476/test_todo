<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class ExceptionLog{
    public function ExceptionLogCreate($error,$errorData){
        $log = [
            'file'=>$error->getFile(),
            'line'=>$error->getLine(),
            'function'=>$errorData["function"],
            'msg' => $error->getMessage(),
            'error_code' => $errorData["code"],
        ];

        Log::error($log);

        $res = [
            'status' => false,
            'error' =>["msg"=>[$error->getMessage()]],
            'error_code'=>$errorData["code"]
        ];

        return $res;
    }
}