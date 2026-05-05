<?php

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('ProjectPolicy', function () {
    beforeEach(function () {
        $this->policy = new ProjectPolicy();
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
    });

    describe('viewAny', function () {
        it('returns false for any user', function () {
            $result = $this->policy->viewAny($this->user);
            expect($result)->toBeFalse();
        });
    });

    describe('view', function () {
        it('returns false for any user', function () {
            $result = $this->policy->view($this->user, $this->project);
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
            $result = $this->policy->update($this->user, $this->project);
            expect($result)->toBeFalse();
        });
    });

    describe('delete', function () {
        it('returns false for any user', function () {
            $result = $this->policy->delete($this->user, $this->project);
            expect($result)->toBeFalse();
        });
    });

    describe('restore', function () {
        it('returns false for any user', function () {
            $result = $this->policy->restore($this->user, $this->project);
            expect($result)->toBeFalse();
        });
    });

    describe('forceDelete', function () {
        it('returns false for any user', function () {
            $result = $this->policy->forceDelete($this->user, $this->project);
            expect($result)->toBeFalse();
        });
    });
});