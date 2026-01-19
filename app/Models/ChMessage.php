<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    protected $table = 'ch_messages';
    protected $fillable = [
        'from_id',
        'to_id',
        'group_id',
        'body',
        'attachment',
        'seen',
    ];
    use HasFactory;
}
