<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    protected $table = 'ch_messages';
    protected $fillable = [
        'from_id',
        'to_id',
        'group_id',
        'body',
        'attachment',
        'seen',
        'reply_id',
        'forward',
        'deleted',
    ];

    protected $casts = [
        'seen' => 'array',
        'forward' => 'boolean',
        'deleted' => 'boolean',
    ];

    use HasFactory;

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function group()
    {
        return $this->belongsTo(Groups_chat::class, 'group_id');
    }

    public function replyTo()
    {
        return $this->belongsTo(ChMessage::class, 'reply_id');
    }
}
