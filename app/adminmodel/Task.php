<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $fillable = [
        'agent_id',
        'month',
        'week',
        'task',
        'deadline',
        'heading',
        'description',
        'admin_id',
        'status',
        'created_at',
        'updated_at',
    ];
    use HasFactory;
}