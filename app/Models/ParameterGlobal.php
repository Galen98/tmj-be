<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterGlobal extends Model
{
    protected $fillable = [
        'name',
        'value',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}
