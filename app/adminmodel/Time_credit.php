<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Time_credit extends Model
{
    protected $table='time_credit';
    public $timestamps=false;
	protected $primaryKey = 'id';

    protected $fillable = [
        'agent_id','time','date'
    ];
    // use SoftDeletes;
    // protected $del = ['deleted_at'];
}