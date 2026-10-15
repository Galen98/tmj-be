<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'whatsapp',
        'email',
        'duration_days',
        'participant_count',
        'include_hotel',
        'departure_location',
    ];

    protected $casts = [
        'include_hotel' => 'boolean',
    ];
}
