<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterFile extends Model
{
    protected $table = 'master_file';
    protected $fillable = [
        'user_id',
        'data_id',
    ];
    use HasFactory;
}
