<?php

namespace App\Http\Controllers;

use App\Http\Requests\TasksRequest;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(?Project $project = null): View
    {
        $projects = Project::withoutGlobalScopes()
            ->with(['owner', 'members'])
            ->where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->get();

        $teamMembers = collect();
        foreach ($projects as $p) {
            foreach ($p->members as $member) {
                if ($member->id !== auth()->id()) {
                    $teamMembers->push($member);
                }
            }
        }
        $users = $teamMembers->unique('id')->values();

        $selectedProjectId = $project?->id ?? $projects->first()?->id;

        return view('edit', compact('projects', 'users', 'selectedProjectId'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(TasksRequest $request): RedirectResponse
    {
        $project = Project::withoutGlobalScopes()->findOrFail($request->validated()['project_id']);
        
        $this->authorize('create', $project);
        
        $validated = $request->validated();

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
        
        $this->authorize('view', $task);

        $canUpdate = Gate::allows('update', $task);

        $projects = Project::withoutGlobalScopes()
            ->with(['owner', 'members'])
            ->where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->get();

        $teamMembers = collect();
        foreach ($projects as $p) {
            foreach ($p->members as $member) {
                if ($member->id !== auth()->id()) {
                    $teamMembers->push($member);
                }
            }
        }
        $users = $teamMembers->unique('id')->values();

        return view('edit', compact('task', 'projects', 'users', 'canUpdate'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(TasksRequest $request, int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        
        $this->authorize('update', $task);
        
        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'],
            'priority' => $validated['priority'] ?? $task->priority,
            'status' => $validated['status'] ?? $task->status,
            'deadline' => $validated['deadline'] ?? null,
            'user_id' => $validated['assigned_to'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Update task status only (for assigned developers).
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        
        $this->authorize('updateStatus', $task);
        
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Task status updated!');
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
        
        $this->authorize('delete', $task);
        
        $task->delete();

        return redirect()->back()->with('success', 'Task archived successfully!');
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