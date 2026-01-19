<?php

namespace App\adminmodel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab_view_lead extends Model
{
    protected $table = 'tab_view_lead';
    protected $fillable = [
        'team_id',
        'total_data',
        'batch',
    ];
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    use HasFactory;
}