<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(): View
    {
        $tasks = Task::with(['project', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        $projects = Project::with(['owner', 'members'])
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereHas('members', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
            })
            ->get();

        $teamMembers = collect();
        foreach ($projects as $project) {
            foreach ($project->members as $member) {
                if ($member->id !== auth()->id()) {
                    $teamMembers->push($member);
                }
            }
            if ($project->owner->id !== auth()->id()) {
                $teamMembers->push($project->owner);
            }
        }
        $users = $teamMembers->unique('id')->values();

        return view('edit', compact('projects', 'users'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:todo,in_progress,done',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'],
            'priority' => $validated['priority'] ?? 'medium',
            'status' => $validated['status'] ?? 'todo',
            'deadline' => $validated['deadline'] ?? null,
            'user_id' => $validated['assigned_to'] ?? null,
        ]);

        return redirect()->route('projects.index')->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(int $id): View
    {
        $task = Task::findOrFail($id);

        $projects = Project::with(['owner', 'members'])
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereHas('members', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
            })
            ->get();

        $teamMembers = collect();
        foreach ($projects as $project) {
            foreach ($project->members as $member) {
                if ($member->id !== auth()->id()) {
                    $teamMembers->push($member);
                }
            }
            if ($project->owner->id !== auth()->id()) {
                $teamMembers->push($project->owner);
            }
        }
        $users = $teamMembers->unique('id')->values();

        return view('edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:todo,in_progress,done',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'],
            'priority' => $validated['priority'] ?? $task->priority,
            'status' => $validated['status'] ?? $task->status,
            'deadline' => $validated['deadline'] ?? null,
            'user_id' => $validated['assigned_to'] ?? null,
        ]);

        return redirect()->route('projects.show', $task->project)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->back()->with('success', 'Task deleted permanently!');
    }

    /**
     * Archive a task.
     */
    public function archive(int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task archived successfully!');
    }

    /**
     * Restore an archived task.
     */
    public function restore(int $id): RedirectResponse
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('archives.index')->with('success', 'Task restored successfully!');
    }
}