<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formpage4 extends Model
{
    protected $table = 'formpage4';
    protected $fillable = [
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'comment',
    ];
    use HasFactory;
}