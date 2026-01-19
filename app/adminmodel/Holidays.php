<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Holidays extends Model
{
    protected $table='holidays';
    public $timestamps=false;
	protected $primaryKey = 'id';

    protected $fillable = [
        'name','date'
    ];
    // use SoftDeletes;
    // protected $del = ['deleted_at'];
}