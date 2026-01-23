<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups_chat extends Model
{
    protected $table = 'group_chat';
    protected $fillable = [
        'name',
        'created_by',
        'user_ids',
        'image',
        'description',
    ];

    protected $casts = [
        'user_ids' => 'array',
    ];

    use HasFactory;

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(ChMessage::class, 'group_id');
    }
}