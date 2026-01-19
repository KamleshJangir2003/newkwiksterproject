<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Break_detail extends Model
{
    use HasFactory;
    protected $table = "break_detail";
    protected $fillable = [
        'break_id',
        'agent_id',
        'time_use',
        'status',
        'created_at',
        'updated_at',
    ];
}
