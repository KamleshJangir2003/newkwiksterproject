<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    use HasFactory;
    protected $table = "bank";
    protected $fillable = [
        'agent_id',
        'holder_name',
        'account_number',
        'ipsc',
        'upi_id',
    ];
}
