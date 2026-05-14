<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'nom_jeune_fille',
        'date_naissance',
        'profession',
        'num_secu_sociale',
        'adresse',
        'telephone',
        'contact_urgence',
    ];

    /**
     * Relation avec l'utilisateur associé
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les rendez-vous du patient
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    /**
     * Relation avec les consultations du patient
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Relation avec le dossier médical du patient
     */
    public function dossierMedical(): HasOne
    {
        return $this->hasOne(DossierMedical::class);
    }
}