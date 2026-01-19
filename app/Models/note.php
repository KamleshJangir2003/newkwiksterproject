<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    protected $table = 'notes';
    protected $fillable = [
        'user_id',
        'notes',
    ];
    use HasFactory;
}
