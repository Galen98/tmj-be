<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUsReply extends Model
{
    protected $fillable = [
        'contact_us_id',
        'message',
        'sent_at',
    ];


    protected $casts = [
        'sent_at' => 'datetime',
    ];


    public function contactUs(): BelongsTo
    {
        return $this->belongsTo(
            ContactUs::class
        );
    }
}
