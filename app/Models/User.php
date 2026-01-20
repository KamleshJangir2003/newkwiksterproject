<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;   // ✅ Add this

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; // ✅ Add SoftDeletes

    protected $fillable = [
        'team_id',      // ✅ Added
        'name',
        'email',
        'phone',
        'password',
        'ip',
        'ip_check',
        'added_by',
        'is_active',
        'status',
        'image',
        'new_pass',
        'mode',
        'sidebar',
        'header',
        'role',
        'gender',
        'designation',
        'profile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
