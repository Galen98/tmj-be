<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrackingGeoModel extends Model
{
    use HasFactory;

    protected $table = 'users_tracking_geo';
    protected $fillable = [
        'ip_address',
        'location',
        'date_time_opened'
    ];
}
