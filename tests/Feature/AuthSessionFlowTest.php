<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from the protected welcome page', function () {
    $response = $this->get(route('me'));

    $response->assertRedirect(route('login'));
});

it('registers a user and starts a session', function () {
    $response = $this->post(route('register.store'), [
        'username' => 'nicofit',
        'email' => 'nico@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect(route('me'));
    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'username' => 'nicofit',
        'email' => 'nico@example.com',
    ]);
});

it('logs in an existing user through the session guard', function () {
    $user = User::factory()->create([
        'email' => 'nico@example.com',
        'password_hash' => bcrypt('secret123'),
    ]);

    $response = $this->post(route('login.attempt'), [
        'email' => $user->email,
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('me'));
    $this->assertAuthenticatedAs($user);
});