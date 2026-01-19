<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passcode extends Model
{
    use HasFactory;
    protected $table = "passcode";
    protected $fillable = [
        'agent_id',
        'passcode',
    ];
}
