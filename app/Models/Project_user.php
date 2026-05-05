<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;



class Member extends Pivot {
    protected $table = 'members';
    public $incrementing = false;
}

