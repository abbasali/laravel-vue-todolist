<?php

namespace App\Http\Controllers\Api;

use App\TodoList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoListResource;
use App\Http\Requests\SaveTodoListRequest;
use App\Http\Requests\DestroyTodoListRequest;

class TodoListsController extends Controller
{
    public function store(SaveTodoListRequest $request)
    {
        $list = new TodoList();
        $list->name = $request->name;
        $list->user_id = $request->user()->id;
        $list->save();

        return new TodoListResource($list);
    }

    public function index(Request $request)
    {
        $lists = TodoList::where('user_id', $request->user()->id)
            ->get();

        return TodoListResource::collection($lists);
    }

    public function destroy(DestroyTodoListRequest $request, TodoList $todoList)
    {
        $todoList->delete();
    }

    public function update(SaveTodoListRequest $request, TodoList $todoList)
    {
        $todoList->name = $request->name;
        $todoList->save();
        return new TodoListResource($todoList);
    }
}
