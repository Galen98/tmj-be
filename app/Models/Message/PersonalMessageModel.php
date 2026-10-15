<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalMessageModel extends Model
{
    use HasFactory;
    protected $table = 'personal_message';
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'message'
    ];
}
