<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La Policy gère ça dans le controller
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['nullable', 'in:low,medium,high'],
            'deadline'    => ['nullable', 'date', 'after_or_equal:today'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status'      => ['nullable', 'in:todo,in_progress,done'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Le titre de la tâche est obligatoire.',
            'priority.in'       => 'La priorité doit être low, medium ou high.',
            'deadline.after_or_equal'    => 'La deadline doit être aujourd\'hui ou dans le futur.',
            'assigned_to.exists'=> 'Ce développeur n\'existe pas.',
        ];
    }
}