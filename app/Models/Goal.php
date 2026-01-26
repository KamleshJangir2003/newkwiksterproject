<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'target_month',
        'target_value',
        'notes'
    ];
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'agent_id');
    }
}
