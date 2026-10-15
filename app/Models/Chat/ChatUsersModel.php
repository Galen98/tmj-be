<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUsersModel extends Model
{
    use HasFactory;
    protected $table = 'chat_users';
    protected $fillable = [
        'full_name',
        'email',
        'session_token',
        'expired_date'
    ];
}
