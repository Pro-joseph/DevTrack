<?php

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('TaskPolicy', function () {
    beforeEach(function () {
        $this->policy = new TaskPolicy();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    });

    describe('viewAny', function () {
        it('returns false for any user', function () {
            $result = $this->policy->viewAny($this->user);
            expect($result)->toBeFalse();
        });
    });

    describe('view', function () {
        it('returns false for any user', function () {
            $result = $this->policy->view($this->user, $this->task);
            expect($result)->toBeFalse();
        });
    });

    describe('create', function () {
        it('returns false for any user', function () {
            $result = $this->policy->create($this->user);
            expect($result)->toBeFalse();
        });
    });

    describe('update', function () {
        it('returns false for any user', function () {
            $result = $this->policy->update($this->user, $this->task);
            expect($result)->toBeFalse();
        });
    });

    describe('delete', function () {
        it('returns false for any user', function () {
            $result = $this->policy->delete($this->user, $this->task);
            expect($result)->toBeFalse();
        });
    });

    describe('restore', function () {
        it('returns false for any user', function () {
            $result = $this->policy->restore($this->user, $this->task);
            expect($result)->toBeFalse();
        });
    });

    describe('forceDelete', function () {
        it('returns false for any user', function () {
            $result = $this->policy->forceDelete($this->user, $this->task);
            expect($result)->toBeFalse();
        });
    });
});