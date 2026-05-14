<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = [
        'rendezvous_id',
        'patient_id',
        'medecin_id',
        'diagnostic',
        'prescription',
        'notes',
        'prochain_rdv',
        'note',
        'type',
    ];

    protected $casts = [
        'prochain_rdv' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'note' => 'float',
    ];

    /**
     * Relation avec le rendez-vous associé
     */
    public function rendezvous(): BelongsTo
    {
        return $this->belongsTo(RendezVous::class, 'rendezvous_id');
    }

    /**
     * Relation avec le patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relation avec le médecin
     */
    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class);
    }
}