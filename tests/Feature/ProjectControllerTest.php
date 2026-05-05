<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('ProjectController', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    describe('GET /projects', function () {
        it('displays projects index for authenticated user', function () {
            $this->actingAs($this->user);
            $response = $this->get('/projects');
            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/projects');
            $response->assertRedirect('/login');
        });
    });

    describe('GET /project/new', function () {
        it('displays create form for authenticated user', function () {
            $this->actingAs($this->user);
            $response = $this->get('/project/new');
            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/project/new');
            $response->assertRedirect('/login');
        });
    });

    describe('POST /project/new', function () {
        it('creates a new project with valid data', function () {
            $this->actingAs($this->user);
            $response = $this->post('/project/new', [
                'title' => 'New Project',
                'description' => 'Project description',
                'deadline' => '2026-06-01',
                'status' => 'planning',
            ]);

            $response->assertRedirect('/projects');
            $this->assertDatabaseHas('projects', [
                'title' => 'New Project',
                'description' => 'Project description',
            ]);
        });

        it('fails to create project without title', function () {
            $this->actingAs($this->user);
            $response = $this->post('/project/new', [
                'description' => 'Project description',
            ]);

            $response->assertSessionHasErrors('title');
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->post('/project/new', [
                'title' => 'New Project',
            ]);

            $response->assertRedirect('/login');
        });
    });

    describe('GET /project/{id}', function () {
        it('displays a specific project', function () {
            $this->actingAs($this->user);
            $project = Project::factory()->create();

            $response = $this->get("/project/{$project->id}");
            $response->assertStatus(200);
        });

        it('returns 404 for non-existent project', function () {
            $this->actingAs($this->user);

            $response = $this->get('/project/999');
            $response->assertStatus(404);
        });
    });

    describe('GET /project/{id}/edit', function () {
        it('displays edit form for a project', function () {
            $this->actingAs($this->user);
            $project = Project::factory()->create();

            $response = $this->get("/project/{$project->id}/edit");
            $response->assertStatus(200);
        });

        it('passes project data to view', function () {
            $this->actingAs($this->user);
            $project = Project::factory()->create(['title' => 'Test Project']);

            $response = $this->get("/project/{$project->id}/edit");
            $response->assertSee('Test Project');
        });
    });

    describe('PUT /project/{id}', function () {
        it('updates a project with valid data', function () {
            $this->actingAs($this->user);
            $project = Project::factory()->create(['title' => 'Old Title']);

            $response = $this->put("/project/{$project->id}", [
                'title' => 'Updated Title',
                'description' => 'Updated description',
                'status' => 'active',
            ]);

            $response->assertRedirect("/project/{$project->id}");
            $this->assertDatabaseHas('projects', [
                'id' => $project->id,
                'title' => 'Updated Title',
            ]);
        });

        it('fails to update project without title', function () {
            $this->actingAs($this->user);
            $project = Project::factory()->create();

            $response = $this->put("/project/{$project->id}", [
                'title' => '',
            ]);

            $response->assertSessionHasErrors('title');
        });
    });
});