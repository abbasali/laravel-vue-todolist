<?php

namespace App\Http\Controllers\Api;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Http\Requests\SaveTodoRequest;
use App\Http\Requests\DeleteTodoRequest;

class TodosController extends Controller
{
    public function store(SaveTodoRequest $request)
    {
        $todo = new Todo();
        $todo->description = $request->description;
        $todo->user_id = $request->user()->id;
        $todo->todo_list_id = $request->list_id;
        $todo->due_at = $request->due_at;
        $todo->completed_at = null;
        $todo->save();

        return new TodoResource($todo);
    }

    public function index(Request $request)
    {
        $todos = Todo::where('user_id', $request->user()->id)
            ->orderBy(DB::raw('completed_at IS NULL'), 'desc')
            ->orderBy('completed_at', 'desc')
            ->get();

        return TodoResource::collection($todos);
    }

    public function destroy(Todo $todo, DeleteTodoRequest $request)
    {
        try {
            if ($todo->delete()) {
                $todos = Todo::where('user_id', $request->user()->id)
                ->orderBy(DB::raw('completed_at IS NULL'), 'desc')
                ->orderBy('completed_at', 'desc')
                ->get();

                return TodoResource::collection($todos);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
    }
}
