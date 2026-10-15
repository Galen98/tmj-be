<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = [
        'name',
        'email',
        'message',
        'is_read',
        'read_at',
    ];


    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];


    public function replies(): HasMany
    {
        return $this->hasMany(
            ContactUsReply::class
        );
    }
}
