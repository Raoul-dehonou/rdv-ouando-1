<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'titre', 'chemin', 'type', 'taille'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}