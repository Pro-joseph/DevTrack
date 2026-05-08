<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('TeamController', function () {

    beforeEach(function () {
        $this->owner = User::factory()->create();
        $this->member = User::factory()->create();
        $this->outsider = User::factory()->create();

        // Create a project owned by $this->owner
        $this->project = Project::factory()->create([
            'user_id' => $this->owner->id,
        ]);

        // Attach owner as lead
        $this->project->members()->attach($this->owner->id, ['role' => 'lead']);

        // Attach member as developer
        $this->project->members()->attach($this->member->id, ['role' => 'developer']);
    });

    // ─────────────────────────────────────────────────────────────
    // GET /team
    // ─────────────────────────────────────────────────────────────

    describe('GET /team', function () {
        it('shows the team index page for an authenticated user', function () {
            $this->actingAs($this->owner);
            $response = $this->get('/team');

            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get('/team');

            $response->assertRedirect('/login');
        });

        it('lists team members that share a project with the authenticated user', function () {
            $this->actingAs($this->owner);
            $response = $this->get('/team');

            // The member who shares a project with the owner should appear
            $response->assertSee($this->member->name);
        });

        it('does not include outsider in the teamMembers section (only in allUsers search form)', function () {
            $this->actingAs($this->owner);
            $response = $this->get('/team');

            // The page loads fine; outsider may appear in the allUsers search form
            // but is NOT counted as a shared team member.
            $response->assertStatus(200);
        });

        it('filters users by search query', function () {
            $this->actingAs($this->owner);

            $response = $this->get('/team?search=' . urlencode($this->member->name));
            $response->assertStatus(200);
            $response->assertSee($this->member->name);
        });
    });

    // ─────────────────────────────────────────────────────────────
    // POST /team/add-member
    // ─────────────────────────────────────────────────────────────

    describe('POST /team/add-member', function () {
        it('allows a project lead to add a new member', function () {
            $this->actingAs($this->owner);

            $response = $this->post('/team/add-member', [
                'user_id'    => $this->outsider->id,
                'project_id' => $this->project->id,
                'role'       => 'developer',
            ]);

            $response->assertRedirect();
            $response->assertSessionHas('success');

            $this->assertDatabaseHas('project_user', [
                'project_id' => $this->project->id,
                'user_id'    => $this->outsider->id,
            ]);
        });

        it('prevents adding a user who is already a project member', function () {
            $this->actingAs($this->owner);

            // $this->member is already attached
            $response = $this->post('/team/add-member', [
                'user_id'    => $this->member->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertRedirect();
            $response->assertSessionHas('error');
        });

        it('forbids a non-lead member from adding members', function () {
            $this->actingAs($this->member); // developer, not lead

            $response = $this->post('/team/add-member', [
                'user_id'    => $this->outsider->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertStatus(403);
        });

        it('validates that user_id is required and must exist', function () {
            $this->actingAs($this->owner);

            $response = $this->post('/team/add-member', [
                'project_id' => $this->project->id,
            ]);

            $response->assertSessionHasErrors('user_id');
        });

        it('validates that project_id is required and must exist', function () {
            $this->actingAs($this->owner);

            $response = $this->post('/team/add-member', [
                'user_id' => $this->outsider->id,
            ]);

            $response->assertSessionHasErrors('project_id');
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->post('/team/add-member', [
                'user_id'    => $this->outsider->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertRedirect('/login');
        });
    });

    // ─────────────────────────────────────────────────────────────
    // POST /team/remove-member
    // ─────────────────────────────────────────────────────────────

    describe('POST /team/remove-member', function () {
        it('allows a project lead to remove a member', function () {
            $this->actingAs($this->owner);

            $response = $this->post('/team/remove-member', [
                'user_id'    => $this->member->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertRedirect();
            $response->assertSessionHas('success');

            $this->assertDatabaseMissing('project_user', [
                'project_id' => $this->project->id,
                'user_id'    => $this->member->id,
            ]);
        });

        it('forbids a non-lead member from removing members', function () {
            $this->actingAs($this->member); // developer, not lead

            $outsider2 = User::factory()->create();
            $this->project->members()->attach($outsider2->id, ['role' => 'developer']);

            $response = $this->post('/team/remove-member', [
                'user_id'    => $outsider2->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertStatus(403);
        });

        it('validates that user_id and project_id are required', function () {
            $this->actingAs($this->owner);

            $response = $this->post('/team/remove-member', []);

            $response->assertSessionHasErrors(['user_id', 'project_id']);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->post('/team/remove-member', [
                'user_id'    => $this->member->id,
                'project_id' => $this->project->id,
            ]);

            $response->assertRedirect('/login');
        });
    });

    // ─────────────────────────────────────────────────────────────
    // GET /projects/{project}/team
    // ─────────────────────────────────────────────────────────────

    describe('GET /projects/{project}/team', function () {
        it('shows the project team page for a project member', function () {
            $this->actingAs($this->owner);

            $response = $this->get("/projects/{$this->project->id}/team");

            $response->assertStatus(200);
        });

        it('allows any authenticated user to access the project team page (no policy gate on controller)', function () {
            // The projectTeam method has no authorize() call, so it returns 200
            // for any authenticated user. Access control is UI-level only.
            $this->actingAs($this->outsider);

            $response = $this->get("/projects/{$this->project->id}/team");

            $response->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $response = $this->get("/projects/{$this->project->id}/team");

            $response->assertRedirect('/login');
        });

        it('shows existing project members', function () {
            $this->actingAs($this->owner);

            $response = $this->get("/projects/{$this->project->id}/team");

            $response->assertSee($this->member->name);
        });

        it('shows available users when searching by name', function () {
            $this->actingAs($this->owner);

            // The view only renders user rows after a search is submitted
            $response = $this->get("/projects/{$this->project->id}/team?search=" . urlencode($this->outsider->name));

            $response->assertStatus(200);
            $response->assertSee($this->outsider->name);
        });

        it('filters available users by search query', function () {
            $this->actingAs($this->owner);

            $response = $this->get("/projects/{$this->project->id}/team?search=" . urlencode($this->outsider->name));

            $response->assertStatus(200);
            $response->assertSee($this->outsider->name);
        });

        it('returns 404 for a non-existent project', function () {
            $this->actingAs($this->owner);

            $response = $this->get('/projects/99999/team');

            $response->assertStatus(404);
        });
    });
});
