<?php

use App\Models\Member;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Member Model', function () {
    it('uses members table', function () {
        $member = new Member();
        expect($member->getTable())->toBe('members');
    });

    it('is non-incrementing', function () {
        $member = new Member();
        expect($member->getIncrementing())->toBeFalse();
    });

    it('can have a user', function () {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $member = new Member([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => 'member',
        ]);

        expect($member->user_id)->toBe($user->id);
    });

    it('can have a project', function () {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $member = new Member([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => 'member',
        ]);

        expect($member->project_id)->toBe($project->id);
    });

    it('can have a role', function () {
        $member = new Member(['role' => 'admin']);
        expect($member->role)->toBe('admin');
    });

    it('can have different roles', function () {
        $roles = ['admin', 'member', 'viewer'];
        foreach ($roles as $role) {
            $member = new Member(['role' => $role]);
            expect($member->role)->toBe($role);
        }
    });
});