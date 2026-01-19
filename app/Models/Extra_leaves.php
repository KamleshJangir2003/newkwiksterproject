<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra_leaves extends Model
{
    protected $table = 'extra_leaves';
    protected $fillable = [
        'agent_id',
        'leaves',
    ];

    use HasFactory;
}
