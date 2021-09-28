<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTodo extends Model
{
    use HasFactory;

    protected $fillable=[
        "assign_to",
        "assign_by",
        "todo_id",
        "completion_time"
    ];
}
