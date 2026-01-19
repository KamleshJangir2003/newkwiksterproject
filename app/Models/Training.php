<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';
    protected $fillable = [
        'user_id',
        'heading',
        'message',
        'image',
    ];
    use HasFactory;
}
