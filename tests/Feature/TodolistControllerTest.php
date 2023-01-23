<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "evan",
            "todolist" => [
                "id" => "1",
                "todo" => "tes todo"
            ],
            "todolist" => [
                "id" => "2",
                "todo" => "pangau"
            ]
        ])->get("/todolist")
            ->assertSeeText("1")
            ->assertSeeText("test todo")
            ->assertSeeText("2")
            ->assertSeeText("pangau");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "evan"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "evan"
        ])->post("/todolist", [
            "todo" => "tes todo"
        ])->assertRedirect("/todolist");
    }
}
