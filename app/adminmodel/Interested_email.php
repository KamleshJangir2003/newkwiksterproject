<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interested_email extends Model
{
    protected $table = 'interested_email_data';
    protected $fillable = [
        'agent_id',
        'company_name',
        'phone',
        'email',
        'trucks',
        'drivers',
        'Comment',
        'status',
        'created_at',
        'updated_at',
    ];
    use HasFactory;
}