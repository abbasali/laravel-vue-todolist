<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Http\Requests\ToggleTodoCompleteRequest;

class ToggleTodoCompleteController extends Controller
{
    public function update(ToggleTodoCompleteRequest $request, Todo $todo)
    {
        // We need to toggle the completed_at
        $todo->completed_at = $todo->completed_at ? null : now();

        $todo->save();

        return new TodoResource($todo);
    }
}
