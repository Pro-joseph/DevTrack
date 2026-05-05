<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('TaskController', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
    });

    describe('GET /tasks', function () {
        it('displays tasks index for authenticated user', function () {
            $this->actingAs($this->user);
            $response = $this->get('/tasks');
            $response->assertStatus(200);
            $response->assertSee('My Tasks');
        });

        it('shows task count', function () {
            $this->actingAs($this->user);
            Task::factory()->count(3)->create();

            $response = $this->get('/tasks');
            $response->assertSee('3 tasks');
        });

        it('shows empty state when no tasks', function () {
            $this->actingAs($this->user);

            $response = $this->get('/tasks');
            $response->assertSee('No tasks found');
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/tasks');
            $response->assertRedirect('/login');
        });
    });

    describe('GET /task/new', function () {
        it('displays create form for authenticated user', function () {
            $this->actingAs($this->user);
            $response = $this->get('/task/new');
            $response->assertStatus(200);
            $response->assertSee('Define Task');
        });

        it('passes projects and users to view', function () {
            $this->actingAs($this->user);
            $response = $this->get('/task/new');
            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/task/new');
            $response->assertRedirect('/login');
        });
    });

    describe('POST /task/new', function () {
        it('creates a new task with valid data', function () {
            $this->actingAs($this->user);

            $response = $this->post('/task/new', [
                'title' => 'New Task',
                'description' => 'Task description',
                'project_id' => $this->project->id,
                'priority' => 'high',
                'status' => 'todo',
                'deadline' => '2026-06-01',
            ]);

            $response->assertRedirect('/projects');
            $this->assertDatabaseHas('tasks', [
                'title' => 'New Task',
                'description' => 'Task description',
                'project_id' => $this->project->id,
                'priority' => 'high',
                'status' => 'todo',
            ]);
        });

        it('fails to create task without title', function () {
            $this->actingAs($this->user);
            $response = $this->post('/task/new', [
                'project_id' => $this->project->id,
            ]);

            $response->assertSessionHasErrors('title');
        });

        it('fails to create task without project', function () {
            $this->actingAs($this->user);
            $response = $this->post('/task/new', [
                'title' => 'New Task',
            ]);

            $response->assertSessionHasErrors('project_id');
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->post('/task/new', [
                'title' => 'New Task',
                'project_id' => $this->project->id,
            ]);

            $response->assertRedirect('/login');
        });
    });

    describe('GET /task/{id}/edit', function () {
        it('displays edit form for a task', function () {
            $this->actingAs($this->user);
            $task = Task::factory()->create();

            $response = $this->get("/task/{$task->id}/edit");
            $response->assertStatus(200);
            $response->assertSee('Edit Task');
        });

        it('passes task data to view', function () {
            $this->actingAs($this->user);
            $task = Task::factory()->create(['title' => 'Test Task']);

            $response = $this->get("/task/{$task->id}/edit");
            $response->assertSee('Test Task');
        });

        it('returns 404 for non-existent task', function () {
            $this->actingAs($this->user);

            $response = $this->get('/task/999/edit');
            $response->assertStatus(404);
        });
    });

    describe('PUT /task/{id}', function () {
        it('updates a task with valid data', function () {
            $this->actingAs($this->user);
            $task = Task::factory()->create(['title' => 'Old Title']);

            $response = $this->put("/task/{$task->id}", [
                'title' => 'Updated Title',
                'description' => 'Updated description',
                'project_id' => $this->project->id,
                'status' => 'in_progress',
                'priority' => 'high',
            ]);

            $response->assertRedirect("/project/{$this->project->id}");
            $this->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'title' => 'Updated Title',
                'status' => 'in_progress',
            ]);
        });

        it('fails to update task without title', function () {
            $this->actingAs($this->user);
            $task = Task::factory()->create();

            $response = $this->put("/task/{$task->id}", [
                'title' => '',
                'project_id' => $this->project->id,
            ]);

            $response->assertSessionHasErrors('title');
        });

        it('fails to update non-existent task', function () {
            $this->actingAs($this->user);

            $response = $this->put('/task/999', [
                'title' => 'Updated Title',
                'project_id' => $this->project->id,
            ]);

            $response->assertStatus(404);
        });
    });

    describe('DELETE /task/{id}', function () {
        it('deletes a task', function () {
            $this->actingAs($this->user);
            $task = Task::factory()->create();

            $response = $this->delete("/task/{$task->id}");

            $response->assertRedirect('/tasks');
            $this->assertDatabaseMissing('tasks', [
                'id' => $task->id,
            ]);
        });

        it('returns 404 for non-existent task', function () {
            $this->actingAs($this->user);

            $response = $this->delete('/task/999');
            $response->assertStatus(404);
        });
    });
});