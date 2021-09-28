<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("todo_id");
            $table->foreign("todo_id")->references("id")->on("todos");
            $table->date("completion_time");
            $table->unsignedBigInteger("assign_to");
            $table->foreign("assign_to")->references("id")->on("users");
            $table->unsignedBigInteger("assign_by");
            $table->foreign("assign_by")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_todos');
    }
}
