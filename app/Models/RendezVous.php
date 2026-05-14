<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date',
        'heure',
        'motif',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'heure' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class);
    }

    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class, 'rendezvous_id');
    }
}