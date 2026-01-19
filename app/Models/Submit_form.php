<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submit_form extends Model
{
    use HasFactory;
    protected $table = 'submit_form';
    protected $fillable = [
        'user_id',
        'dinner_break',
        'tea_break',
        'short_break',
        'training_break',
        'meeting_break',
        'hours',
        'minutes',
        'seconds',
        'status',
    ];
}
