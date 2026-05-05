<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Project Model', function () {
    it('can be created with factory', function () {
        $project = Project::factory()->create();
        expect($project)->toBeInstanceOf(Project::class);
        expect($project->id)->toBeGreaterThan(0);
    });

    it('can have a title', function () {
        $project = Project::factory()->create(['title' => 'My Project']);
        expect($project->title)->toBe('My Project');
    });

    it('can have a description', function () {
        $project = Project::factory()->create(['description' => 'Project description']);
        expect($project->description)->toBe('Project description');
    });

    it('can have a status', function () {
        $project = Project::factory()->create(['status' => 'active']);
        expect($project->status)->toBe('active');
    });

    it('can have a deadline', function () {
        $deadline = now()->addDays(7);
        $project = Project::factory()->create(['deadline' => $deadline]);
        expect($project->deadline)->toEqual($deadline);
    });

    it('can have many tasks', function () {
        $project = Project::factory()->create();
        expect($project->tasks)->toBeEmpty();
    });

    it('can have many members', function () {
        $project = Project::factory()->create();
        expect($project->members)->toBeEmpty();
    });
});