<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlerteUrgence extends Model
{
    /**
     * Nom de la table associée (pluriel).
     */
    protected $table = 'alertes_urgences';

    protected $fillable = [
        'nom',
        'telephone',
        'description',
        'traitee',
        'traitee_le',
        'traitee_par'
    ];

    protected $casts = [
        'traitee' => 'boolean',
        'traitee_le' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a traité l'alerte.
     */
    public function traiteur()
    {
        return $this->belongsTo(User::class, 'traitee_par');
    }
}