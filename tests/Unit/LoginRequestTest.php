<?php

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('LoginRequest', function () {
    it('has correct authorization', function () {
        $request = new LoginRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('validates email is required', function () {
        $request = new LoginRequest();
        $request->setMethod('POST');

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['password' => 'password123'],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
    });

    it('validates password is required', function () {
        $request = new LoginRequest();
        $request->setMethod('POST');

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['email' => 'test@example.com'],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('password'))->toBeTrue();
    });

    it('validates email is valid format', function () {
        $request = new LoginRequest();
        $request->setMethod('POST');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'email' => 'invalid-email',
                'password' => 'password123',
            ],
            $request->rules()
        );

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
    });

    it('passes with valid data', function () {
        $request = new LoginRequest();
        $request->setMethod('POST');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'email' => 'test@example.com',
                'password' => 'password123',
            ],
            $request->rules()
        );

        expect($validator->passes())->toBeTrue();
    });

    it('generates correct throttle key', function () {
        $request = new LoginRequest();
        $request->merge(['email' => 'Test@Example.com']);

        $key = $request->throttleKey();
        expect($key)->toContain('test@example.com');
    });
});