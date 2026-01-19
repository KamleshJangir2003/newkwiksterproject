<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dayendreport extends Model
{
    protected $table = 'dayendreport';
    protected $fillable = [
        'user_id',
        'intrested',
        'pipeline',
        'total_call',
        'call_connect',
        'date',
    ];
    use HasFactory;
}
