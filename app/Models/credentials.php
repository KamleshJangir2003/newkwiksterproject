<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class credentials extends Model
{
    protected $table = 'credentials';
    protected $fillable = [
        'team_id',
        'ajent_id',
        'platform',
        'username',
        'password',
        'link',
    ];
    use HasFactory;
}
