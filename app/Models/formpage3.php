<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formpage3 extends Model
{
    protected $table = 'formpage3';
    protected $fillable = [
        'comapny_name',
        'year',
        'Make',
        'model',
        'vin',
        'license_no',
        'signature',
    ];
    use HasFactory;
}