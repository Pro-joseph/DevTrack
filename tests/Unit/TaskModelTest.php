<?php

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Task Model', function () {
    it('can be created with factory', function () {
        $task = Task::factory()->create();
        expect($task)->toBeInstanceOf(Task::class);
        expect($task->id)->toBeGreaterThan(0);
    });

    it('can have a title', function () {
        $task = Task::factory()->create(['title' => 'My Task']);
        expect($task->title)->toBe('My Task');
    });

    it('can have a description', function () {
        $task = Task::factory()->create(['description' => 'Task description']);
        expect($task->description)->toBe('Task description');
    });

    it('can have a status', function () {
        $task = Task::factory()->create(['status' => 'done']);
        expect($task->status)->toBe('done');
    });

    it('can have a priority', function () {
        $task = Task::factory()->create(['priority' => 'high']);
        expect($task->priority)->toBe('high');
    });

    it('can belong to a project', function () {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);
        expect($task->project_id)->toBe($project->id);
    });

    it('can be assigned to a user', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        expect($task->user_id)->toBe($user->id);
    });

    it('can have a deadline', function () {
        $deadline = now()->addDays(7);
        $task = Task::factory()->create(['deadline' => $deadline]);
        expect($task->deadline)->toEqual($deadline);
    });
});