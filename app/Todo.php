<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $dates = [
        'due_at',
        'completed_at',
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
