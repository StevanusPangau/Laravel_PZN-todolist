<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        return response()->view("todolist.todolist", [
            "tittle" => "Todolist",
            "todolist" => $this->todolistService->getTodolist()
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            return response()->view("todolist.todolist", [
                "tittle" => "Todolist",
                "todolist" => $this->todolistService->getTodolist(),
                "error" => "Todo is required",
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $todoId)
    {
    }
}
