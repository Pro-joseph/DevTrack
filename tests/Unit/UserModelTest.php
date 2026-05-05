<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('User Model', function () {
    it('can be created with factory', function () {
        $user = User::factory()->create();
        expect($user)->toBeInstanceOf(User::class);
        expect($user->id)->toBeGreaterThan(0);
    });

    it('has name, email, and password fillable', function () {
        $user = new User();
        expect($user->getFillable())->toContain('name', 'email', 'password');
    });

    it('has password and remember_token hidden', function () {
        $user = new User();
        expect($user->getHidden())->toContain('password', 'remember_token');
    });

    it('casts email_verified_at to datetime', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        expect($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
    });

    it('casts password to hashed', function () {
        $user = User::factory()->create(['password' => 'secret']);
        expect($user->password)->not->toBe('secret');
    });

    it('can create user with unique email', function () {
        User::factory()->create(['email' => 'unique@example.com']);
        $user = User::factory()->create(['email' => 'another@example.com']);
        expect($user->email)->not->toBe('unique@example.com');
    });

    it('can have many projects through membership', function () {
        $user = User::factory()->create();
        expect($user->projects)->toBeEmpty();
    });

    it('can have many assigned tasks', function () {
        $user = User::factory()->create();
        expect($user->assignedTasks)->toBeEmpty();
    });

    it('has correct fillable attributes', function () {
        $user = new User();
        expect($user->getFillable())->toContain('name', 'email', 'password');
    });

    it('has hidden attributes for serialization', function () {
        $user = new User();
        expect($user->getHidden())->toContain('password', 'remember_token');
    });
});