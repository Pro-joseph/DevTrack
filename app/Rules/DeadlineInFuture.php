<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DeadlineInFuture implements ValidationRule
{
    protected $task;

    public function __construct(Task $task = null)
    {
        $this->task = $task;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        $taskDeadline = $this->task?->deadline;

        if ($taskDeadline && $value === date('Y-m-d', strtotime($taskDeadline))) {
            return;
        }

        if (strtotime($value) <= strtotime('today')) {
            $fail('La deadline doit être dans le futur.');
        }
    }
}
