<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateMessageModel extends Model
{
    use HasFactory;
    protected $table = 'corporate_message';
    protected $fillable = [
        'corporate_name',
        'corporate_contact',
        'hari_acara',
        'jumlah_peserta',
        'add_hotel',
        'lokasi_start',
    ];
}
