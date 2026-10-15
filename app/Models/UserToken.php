<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = [
        'token',
        'status',
        'last_seen_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_seen_at' => 'datetime',
    ];
}
