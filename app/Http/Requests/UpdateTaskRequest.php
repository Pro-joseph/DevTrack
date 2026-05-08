<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La Policy gère ça dans le controller
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['sometimes', 'in:low,medium,high'],
            'deadline'    => ['nullable', 'date', new \App\Rules\DeadlineInFuture($this->route('task'))],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status'      => ['sometimes', 'in:todo,in_progress,done'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string'      => 'Le titre doit être une chaîne de caractères.',
            'priority.in'       => 'La priorité doit être low, medium ou high.',
            'deadline.after'    => 'La deadline doit être dans le futur.',
            'assigned_to.exists'=> 'Ce développeur n\'existe pas.',
        ];
    }
}