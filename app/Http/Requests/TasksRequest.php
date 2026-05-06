<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TasksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:todo,in_progress,done',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}