<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formpage2 extends Model
{
    protected $table = 'formpage2';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'dot',
        'mc_docket',
        'equipment',
        'address',
        'city',
        'state',
        'zip',
        'certificate',
        'license',
    ];

    use HasFactory;
}