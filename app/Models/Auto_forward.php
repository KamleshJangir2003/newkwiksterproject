<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto_forward extends Model
{
    use HasFactory;
    protected $table = "auto_forward";
    protected $fillable = [
        'user_id',
        'tab_view_ids',
        'status',
    ];
}
