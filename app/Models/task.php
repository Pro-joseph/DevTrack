<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'priority', 'project_id', 'user_id', 'deadline', 'assigned_to'];

    protected $with = ['project', 'user'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function getFormattedStatusAttribute(): string
{
    return match($this->status) {
        'todo'        => 'To Do',
        'in_progress' => 'In Progress',
        'done'        => 'Done',
        default       => ucfirst($this->status),
    };
}
}
