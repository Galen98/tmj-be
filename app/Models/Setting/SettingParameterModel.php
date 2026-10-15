<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingParameterModel extends Model
{
    use HasFactory;

    protected $table = 'setting_parameter';
    protected $fillable = [
        'key',
        'value',
        'description'
    ];
}
