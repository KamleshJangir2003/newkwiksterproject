<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary_calculate extends Model
{
    protected $table = 'salary_calculate';
    protected $fillable = [
        'agent_id',
        'salary',
        'month',
    ];
    use HasFactory;
}
