<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'class_id',
        'user_id',
        'subject_id',
        'point',
        'type',
    ];
}
