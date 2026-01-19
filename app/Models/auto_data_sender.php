<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auto_data_sender extends Model
{
    use HasFactory;
    protected $table = "auto_data_sender";
    protected $fillable = [
        'agent_id',
        'last_time',
    ];
}
