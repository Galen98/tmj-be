<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDataModel extends Model
{
    use HasFactory;
    protected $table = 'chat_data';
    protected $fillable = [
        'chat_sessions_token',
        'message',
        'sender_type',
        'timestamp'
    ];
}
