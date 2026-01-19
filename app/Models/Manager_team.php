<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager_team extends Model
{
    protected $table = 'manager_team';
    protected $fillable = [
        'manager_id',
        'team_ids',
        'file3',
        'file4',
        'file5',
        'comment',
    ];
    use HasFactory;
}