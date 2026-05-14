<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medecin extends Model
{
    protected $fillable = [
        'user_id',
        'specialite',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur associé
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les rendez-vous du médecin
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    /**
     * Relation avec les consultations effectuées par ce médecin
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Relation avec les disponibilités du médecin (si la table existe)
     */
    public function disponibilites(): HasMany
    {
        return $this->hasMany(Disponibilite::class);
    }

    /**
     * Scope pour filtrer les médecins actifs
     */
    public function scopeActif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accesseur pour obtenir le nom complet du médecin
     */
    public function getNomCompletAttribute()
    {
        return $this->user ? $this->user->name : 'Médecin inconnu';
    }
}