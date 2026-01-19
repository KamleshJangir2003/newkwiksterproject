<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managerfwd extends Model
{
    protected $table = 'manager_fwd';
    protected $fillable = [
        'agent_id',
        'data_id',
        'batch',
        'team_id',
    ];
    public function excelData()
    {
        return $this->belongsTo(ExcelData::class, 'data_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }
    use HasFactory;
}
