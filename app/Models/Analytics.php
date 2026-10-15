<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Travel;

class Analytics extends Model
{
    protected $fillable = [
        'user_token_id',
        'ip_address',
        'path',
        'country',
        'travel_id',
        'province',
        'user_agent',
    ];


    public function userToken(): BelongsTo
    {
        return $this->belongsTo(
            UserToken::class
        );
    }

    public function travel()
    {
        return $this->belongsTo(
            Travel::class,
            'travel_id'
        );
    }
}
