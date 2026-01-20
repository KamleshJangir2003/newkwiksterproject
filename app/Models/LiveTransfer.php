<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'from_admin_id',
        'to_agent_id',
        'status',
    ];

    public function lead()
    {
        return $this->belongsTo(ExcelData::class, 'lead_id');
    }

    public function fromAdmin()
    {
        return $this->belongsTo(User::class, 'from_admin_id');
    }

    public function toAgent()
    {
        return $this->belongsTo(User::class, 'to_agent_id');
    }
}
