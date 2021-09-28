<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Services\ExceptionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createUser(CreateUserRequest $request,ExceptionLog $errorLog){
        try{
            $data = $request->all();
            $data["role"] = 2;
            $user = User::create($data);
            return view("singIn")->with("User register");
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
        }
    }

    public function userlist(ExceptionLog $errorLog){
        try{
            $user = User::all()->filter(function($query){
                return $query->id != Auth::user()->id;
            });
            return view('User-List')->with(["data"=>$user]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
        }
    }
}
