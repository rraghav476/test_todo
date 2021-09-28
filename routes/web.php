<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('user',[UserController::class,'userlist']);

    Route::get('/todo',[TodoController::class,'viewTodo'])->name('Todo');
    Route::get('todo/{op?}',[TodoController::class,'viewTodo'])->name('Todo');
    Route::post('create-todo',[TodoController::class,'createTodo'])->name('create-todo');
    Route::get('assign-todo/{id?}',[TodoController::class,'GetUserToAssignTodo']);
    Route::post('assign-todo',[TodoController::class,'assignTodo'])->name('assign-todo');
    Route::get('edit-todo/{id}',[TodoController::class,'editableTodo']);
    Route::post('update-todo',[TodoController::class,'updateTodo'])->name('update-todo');
    Route::get('assign-todo-list',[TodoController::class,'assignListOfTodo'])->name('assign-list');


    Route::post("assign-todo",[TodoController::class,"AssignTodo"]);
});

require __DIR__.'/auth.php';
