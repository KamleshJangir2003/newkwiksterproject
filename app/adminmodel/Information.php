<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';
    protected $fillable = [
        'agent_id',
        'text',
        'duration',
        'status',
        'created_at',
        'updated_at',
    ];
    use HasFactory;
}