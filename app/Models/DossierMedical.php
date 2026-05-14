<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DossierMedical extends Model
{
    protected $fillable = [
        'patient_id',
        'groupe_sanguin',
        'antecedents',
        'allergies',
        'traitements_actuels',
    ];

    /**
     * Relation avec le patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}