<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class task extends Model
{
    protected $fillable = ['project_id', 'assigned_to', 'title', 'description', 'deadline', 'priority', 'status'];

public function project(): BelongsTo {
    return $this->belongsTo(Project::class);
}

public function assignee(): BelongsTo {
    return $this->belongsTo(User::class, 'assigned_to');
}
}
