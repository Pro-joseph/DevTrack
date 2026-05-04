<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class project extends Model
{

protected $fillable = ['title', 'description', 'deadline', 'status'];

public function members(): BelongsToMany {
    return $this->belongsToMany(User::class)->withPivot('role');
}

public function tasks(): HasMany {
    return $this->hasMany(Task::class);
}
}
