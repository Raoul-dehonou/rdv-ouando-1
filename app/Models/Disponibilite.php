<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    use HasFactory;

    protected $fillable = ['medecin_id', 'date', 'heure_debut', 'heure_fin', 'duree'];

    protected $casts = [
        'date' => 'date',
    ];

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    // Relation facultative pour faciliter les vérifications (non utilisée dans la méthode actuelle)
    public function rendezvous()
    {
        return $this->hasMany(RendezVous::class, 'medecin_id', 'medecin_id')
            ->whereDate('date', $this->date);
    }
}