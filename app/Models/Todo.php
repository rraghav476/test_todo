<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todo extends Model
{
    use HasFactory;

    protected $fillable=[
        "name",
        "created_by",
        "description"
    ];

    public function assignTo(){
        return $this->hasMany(AssignTodo::class);
    }
}
