<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $table = 'addresses';
    protected $fillable = [
        'user_id',
        'address',
        'city',
        'country',
        'zip',
    ];
    use HasFactory;
}
