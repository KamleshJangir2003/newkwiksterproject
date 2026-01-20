<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomSetting extends Model
{
    use HasFactory;

    protected $table = 'zoom_settings';

    protected $fillable = [
        'account_id',
        'client_id',
        'client_secret'
    ];
}
