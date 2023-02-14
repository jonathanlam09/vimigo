<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Announcement extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'type_id',
        'desc',
        'image',
        'attachment',
    ];

    protected $hidden = [
        'active',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}