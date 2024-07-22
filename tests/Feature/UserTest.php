<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $email = 'test@example.com';

    public function testUserRegistration(): void
    {
        $email = fake()->email;

        $response = $this->post('/register', [
            'name' => fake()->name,
            'email' => $email,
            'password' => $email,
            'password_confirmation' => $email,
        ]);

        $response->assertRedirect('/projects');
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    public function testUserLogin():void {
        $this->post('/login', [
            'email' => $this->email,
            'password' => $this->email,
        ]);

        $user = User::query()->where('email', $this->email)->first();
        $this->assertAuthenticatedAs($user);
    }
}
