<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary_cycle extends Model
{
    protected $table = 'salary_cycle';
    protected $fillable = [
        'start_date',
        'end_date'
    ];
    use HasFactory;
}
