<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTodoRequest;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Services\ExceptionLog;
use App\Models\AssignTodo;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\FuncCall;

class TodoController extends Controller
{
    private $errorLog;
    public function __construct(ExceptionLog $errorLog)
    {
        $this->errorLog = $errorLog;
    }
    public function viewTodo($op =false){
        try{
            if($op == "create"){
                return view('todos')->with(["msg"=>"Todo create successfully","op"=>1]);
            }
            $data = $this->todoList();
            return view('todos')->with(["msg"=>"todo list","data"=>$data,"op"=>5]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $this->errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }
    public function CreateTodo(CreateTodoRequest $request,ExceptionLog $errorLog){
        try{
            $user = Auth::user();
            $todo = Todo::create(["name"=>$request->name,"created_by"=>$user->id,"description"=>$request->description]);
            $AssignTo = User::all();
            $data = $this->todoList();
            return view('todos')->with(["msg"=>"Todo create successfully","data"=>$data,"assignTo"=>$AssignTo,"create"=>false]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()])->withInput($request->all());
        }
    }

    public function assignListOfTodo(){
        try{
            $data = $this->assignToList();
            // dd($data);
            return view('Assign-Todo')->with(["msg"=>"Todo create successfully","data"=>$data]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $this->errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }

    public function UpdateTodo(Request $request,ExceptionLog $errorLog){
        try{
            $todo = Todo::find($request->id);
            $todo->name = $request->name;
            $todo->description = $request->description;
            $todo->save();
            $data = $this->todoList();
            return view('Todos')->with(["msg"=>"Todo create successfully","data"=>$data,'op'=>5]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }

    public function deleteTodo(Request $request,Todo $todo,ExceptionLog $errorLog){
        try{
            dd($todo);
            $todo->delete();
            $data = $this->todoList();
            return redirect()->back()->with(["msg"=>"Todo Delete successfully","data"=>$data]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }

    public function todoList(){
        $data = Todo::all();
        return $data;
    }

    public function assignToList(){
        try{
            // if(!Gate::check("Admin")){
            //     return redirect()->back()->with(["error"=>"permission denied"]);
            // }
        $data = Todo::select("todos.id","todos.name","todos.description","todos.created_by","assign_to")
                ->Join('assign_todos','todos.id','assign_todos.todo_id')
                ->get();
        // dd($data);
        $data = $data->map(
            function($query){
                $assignTo = user::find($query->assign_to)->name;
                // dd($query->name);
                $createdBy = user::find($query->created_by)->name;
                return ["id"=>$query->id,"name"=>$query->name,"description"=>$query->description,"createdBy"=>$createdBy,"assignTo"=>$assignTo];
            });
            // dd($data);
        return $data;
        }catch(\Throwable $e){
            dd($e);
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $this->errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }

    public function GetUserToAssignTodo($id){
        try{
            $data = User::all();
            return view('todos')->with(["msg"=>"list of user",'id'=>$id,'data'=>$data,"op"=>3]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $this->errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }

    public function AssignTodo(AssignTodoRequest $request,ExceptionLog $errorLog){
        try{
            $data = $request->except('_token');
            $timestamp = strtotime($data['completion_time']);
            $data["assign_by"] = Auth::user()->id;
            $create = AssignTodo::create($data);
            if(!$create){
                throw new \Exception("todo not Assign");
            }
            return view('Todos')->with(["msg"=>"Todo Assign successfully","data"=>$data,'op'=>5]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $errorLog->ExceptionLogCreate($e,$errorData);
            dd($e);
            return redirect()->back()->with(["errors"=>$e->getMessage()]);
        }
    }

    public function editableTodo($id){
        try{
            if(!Gate::check("Admin")){
                return redirect()->back()->with(["error"=>"permission denied"]);
            }
            $data = Todo::find($id);
            return view('todos')->with(["msg"=>"todo list","data"=>$data,"op"=>4]);
        }catch(\Throwable $e){
            $errorData=["function"=>__FUNCTION__,"code"=>"UC-001"];
            $this->errorLog->ExceptionLogCreate($e,$errorData);
            return redirect()->back()->with(["error"=>$e->getMessage()]);
        }
    }
}
