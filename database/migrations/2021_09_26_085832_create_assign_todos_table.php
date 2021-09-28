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
            $table->foreign("todo_id")->references("id")->on("todos")->onDelete('cascade');
            $table->date("completion_time");
            $table->unsignedBigInteger("assign_to");
            $table->foreign("assign_to")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("assign_by")->nullable();
            $table->foreign("assign_by")->references("id")->on("users")->onDelete('set null');
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
