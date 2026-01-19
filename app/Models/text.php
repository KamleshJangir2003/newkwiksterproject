<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class text extends Model
{
    protected $table = 'texts';
    protected $fillable = [
        'user_id',
        'text'
    ];
    use HasFactory;
}
