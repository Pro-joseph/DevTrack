<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // On gérera les permissions avec les Policies plus tard
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['sometimes', 'in:planning,active,on_hold,completed'],
            'deadline'    => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Le nom du projet est obligatoire.',
            'status.in'       => 'Le statut choisi est invalide.',
            'deadline.after'  => 'La deadline doit être dans le futur.',
        ];
    }
}