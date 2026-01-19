<?php

namespace App\adminmodel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sameday extends Model
{
    protected $table = 'sameday';
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name','image', 'ip', 'added_by', 'is_active'
    ];

}