<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'list' => $this->todoList->name,
            'list_id' => $this->todo_list_id,
            'due_at' => $this->due_at,
            'due_at_formatted' => $this->due_at ? $this->due_at->format('jS M, Y H:ia') : '',
            'completed_at' => $this->completed_at,
        ];
    }
}
