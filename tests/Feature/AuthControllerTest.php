<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('AuthController', function () {
    describe('GET /login', function () {
        it('displays the login page', function () {
            $response = $this->get('/login');
            $response->assertStatus(200);
        });
    });

    describe('POST /login', function () {
        it('logs in with valid credentials', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123'),
            ]);

            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'password123',
            ]);

            $response->assertRedirect('/dashboard');
            $this->assertAuthenticatedAs($user);
        });

        it('fails login with invalid credentials', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123'),
            ]);

            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);

            $response->assertSessionHasErrors('email');
            $this->assertGuest();
        });

        it('fails login with missing email', function () {
            $response = $this->post('/login', [
                'password' => 'password123',
            ]);

            $response->assertSessionHasErrors('email');
        });

        it('fails login with missing password', function () {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
            ]);

            $response->assertSessionHasErrors('password');
        });
    });

    describe('GET /register', function () {
        it('displays the registration page', function () {
            $response = $this->get('/register');
            $response->assertStatus(200);
        });
    });

    describe('POST /register', function () {
        it('registers a new user with valid data', function () {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'newuser@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertRedirect('/dashboard');
            $this->assertAuthenticated();
            $this->assertDatabaseHas('users', [
                'name' => 'Test User',
                'email' => 'newuser@example.com',
            ]);
        });

        it('fails registration with invalid email', function () {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'invalid-email',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertSessionHasErrors('email');
        });

        it('fails registration with short password', function () {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

            $response->assertSessionHasErrors('password');
        });

        it('fails registration with mismatched passwords', function () {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different123',
            ]);

            $response->assertSessionHasErrors('password');
        });

        it('fails registration with duplicate email', function () {
            User::factory()->create(['email' => 'existing@example.com']);

            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'existing@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertSessionHasErrors('email');
        });
    });

    describe('POST /logout', function () {
        it('logs out the authenticated user', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $response = $this->post('/logout');

            $response->assertRedirect('/login');
            $this->assertGuest();
        });
    });
});