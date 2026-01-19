<?php

namespace App\adminmodel;
use Illuminate\Database\Eloquent\Model;

class Breaks extends Model
{
    protected $table = 'breaks';
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name','duration', 'status', 'added_by','created_at','updated_at'
    ];
  
}
