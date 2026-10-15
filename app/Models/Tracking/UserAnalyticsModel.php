<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnalyticsModel extends Model
{
    use HasFactory;

    protected $table = 'users_analytics';
    protected $fillable = [
        'ip_address',
        'travel_item_id',
        'link',
        'page_name',
        'date_opened',
        'travel_name',
        'details'
    ];
}
