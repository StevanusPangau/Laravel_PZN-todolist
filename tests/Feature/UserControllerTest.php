<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLogin()
    {
        $this->get('/login')->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession(["user" => "evan"])
            ->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "evan",
            "password" => "1sampai8"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "evan");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession(["user" => "evan"])
            ->post('/login', [
                "user" => "tes",
                "password" => "salah"
            ])
            ->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText("User or Password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "tes",
            "password" => "salah"
        ])->assertSeeText("User or Password wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "evan"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
