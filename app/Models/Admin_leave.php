<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_leave extends Model
{
    protected $table = 'admin_leave';
    protected $fillable = [
        'agent_id',
        'leaves'
    ];
    use HasFactory;
}
