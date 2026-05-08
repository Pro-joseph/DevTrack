<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * GET /api/projects/{project}/tasks
     */
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with(['user', 'assignee'])
            ->get();

        return TaskResource::collection($tasks);
    }

    /**
     * GET /api/projects/{project}/tasks/{task}
     */
    public function show(Project $project, Task $task)
    {
        return new TaskResource($task);
    }
}