<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    protected $table='emails';
    protected $fillable=[
        'user_id',
        'emails',
    ];
    use HasFactory;
}
