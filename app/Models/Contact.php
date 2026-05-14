<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'email', 'telephone', 'sujet', 'message', 'lu', 'traite', 'date_envoi'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'traite' => 'boolean',
        'date_envoi' => 'datetime',
    ];
}