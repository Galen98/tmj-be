<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSessionModel extends Model
{
    use HasFactory;
    protected $table = 'chat_sessions';
    protected $fillable = [
        'travel_item_id',
        'thumbnails',
        'token',
        'travel_name',
        'link'
    ];
}
