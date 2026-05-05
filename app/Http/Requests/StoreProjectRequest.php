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
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:planning,active,on_hold,completed'],
            'deadline'    => ['nullable', 'date', 'after:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Le nom du projet est obligatoire.',
            'status.in'       => 'Le statut choisi est invalide.',
            'deadline.after'  => 'La deadline doit être dans le futur.',
        ];
    }
}