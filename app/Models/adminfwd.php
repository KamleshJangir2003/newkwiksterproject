<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminfwd extends Model
{
    protected $table = 'admin_fwd';
    protected $fillable = [
        'mng_id',
        'data_id',
        'batch',
    ];
    public function excelData()
    {
        return $this->belongsTo(ExcelData::class, 'data_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'mng_id', 'id');
    }
    use HasFactory;
}
