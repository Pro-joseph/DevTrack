<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Other Routes', function () {
    describe('GET / (home redirect)', function () {
        it('redirects to dashboard', function () {
            $response = $this->get('/');
            $response->assertRedirect('/dashboard');
        });
    });

    describe('GET /dashboard', function () {
        it('displays dashboard for authenticated user', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $response = $this->get('/dashboard');
            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/dashboard');
            $response->assertRedirect('/login');
        });

        it('has dashboard route name', function () {
            $route = app()->routes->getByName('dashboard');
            expect($route)->not->toBeNull();
        });
    });

    describe('GET /archives', function () {
        it('displays archives for authenticated user', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $response = $this->get('/archives');
            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/archives');
            $response->assertRedirect('/login');
        });
    });

    describe('Route names', function () {
        it('has projects.index route', function () {
            $route = app()->routes->getByName('projects.index');
            expect($route)->not->toBeNull();
        });

        it('has projects.create route', function () {
            $route = app()->routes->getByName('projects.create');
            expect($route)->not->toBeNull();
        });

        it('has projects.store route', function () {
            $route = app()->routes->getByName('projects.store');
            expect($route)->not->toBeNull();
        });

        it('has projects.show route', function () {
            $route = app()->routes->getByName('projects.show');
            expect($route)->not->toBeNull();
        });

        it('has projects.edit route', function () {
            $route = app()->routes->getByName('projects.edit');
            expect($route)->not->toBeNull();
        });

        it('has projects.update route', function () {
            $route = app()->routes->getByName('projects.update');
            expect($route)->not->toBeNull();
        });

        it('has tasks.index route', function () {
            $route = app()->routes->getByName('tasks.index');
            expect($route)->not->toBeNull();
        });

        it('has tasks.create route', function () {
            $route = app()->routes->getByName('tasks.create');
            expect($route)->not->toBeNull();
        });

        it('has tasks.store route', function () {
            $route = app()->routes->getByName('tasks.store');
            expect($route)->not->toBeNull();
        });

        it('has tasks.edit route', function () {
            $route = app()->routes->getByName('tasks.edit');
            expect($route)->not->toBeNull();
        });

        it('has tasks.update route', function () {
            $route = app()->routes->getByName('tasks.update');
            expect($route)->not->toBeNull();
        });

        it('has team.index route', function () {
            $route = app()->routes->getByName('team.index');
            expect($route)->not->toBeNull();
        });

        it('has archives.index route', function () {
            $route = app()->routes->getByName('archives.index');
            expect($route)->not->toBeNull();
        });

        it('has logout route', function () {
            $route = app()->routes->getByName('logout');
            expect($route)->not->toBeNull();
        });

        it('has login route', function () {
            $route = app()->routes->getByName('login');
            expect($route)->not->toBeNull();
        });

        it('has register route', function () {
            $route = app()->routes->getByName('register');
            expect($route)->not->toBeNull();
        });
    });
});