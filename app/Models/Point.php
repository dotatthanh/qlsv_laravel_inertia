<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'point',
    ];
}
