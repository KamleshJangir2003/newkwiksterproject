<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups_chat extends Model
{
    protected $table = 'groups_chat';
    protected $fillable = [
        'name',
        'created_by',
        'user_ids',
        'image',
    ];

    use HasFactory;
}