<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('ProfileController', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    describe('Profile routes (if defined)', function () {
        it('can test profile edit if route exists', function () {
            $this->actingAs($this->user);

            if (app()->routes->has('profile.edit')) {
                $response = $this->get('/profile');
                $response->assertStatus(200);
            } else {
                $this->markTestSkipped('Profile route not defined');
            }
        });

        it('can test profile update if route exists', function () {
            $this->actingAs($this->user);

            if (app()->routes->has('profile.update')) {
                $response = $this->put('/profile', [
                    'name' => 'Updated Name',
                    'email' => $this->user->email,
                ]);

                $response->assertRedirect();
                $this->assertDatabaseHas('users', [
                    'id' => $this->user->id,
                    'name' => 'Updated Name',
                ]);
            } else {
                $this->markTestSkipped('Profile update route not defined');
            }
        });

        it('can test profile destroy if route exists', function () {
            $this->actingAs($this->user);

            if (app()->routes->has('profile.destroy')) {
                $response = $this->delete('/profile', [
                    'password' => 'password',
                ]);

                $response->assertRedirect();
                $this->assertDatabaseMissing('users', [
                    'id' => $this->user->id,
                ]);
            } else {
                $this->markTestSkipped('Profile destroy route not defined');
            }
        });
    });
});