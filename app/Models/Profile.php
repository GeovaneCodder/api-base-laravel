<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'user_id',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
