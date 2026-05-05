<?php

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('ProfileUpdateRequest', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    it('has correct authorization', function () {
        $request = new ProfileUpdateRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('validates name is required', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['email' => 'test@example.com'],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('name'))->toBeTrue();
    });

    it('validates name is not too long', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'name' => str_repeat('a', 256),
                'email' => 'test@example.com',
            ],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('name'))->toBeTrue();
    });

    it('validates email is required', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['name' => 'Test User'],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
    });

    it('validates email is valid format', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'name' => 'Test User',
                'email' => 'invalid-email',
            ],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
    });

    it('passes with valid data', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ],
            $request->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    it('allows updating to same email', function () {
        $request = new ProfileUpdateRequest();
        $request->setMethod('PUT');

        $rules = $request->rules();
        $rules['email'][] = 'ignore:' . $this->user->id;

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'name' => 'Test User',
                'email' => $this->user->email,
            ],
            $rules
        );

        expect($validator->passes())->toBeTrue();
    });
});