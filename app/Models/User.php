<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations avec les rôles
    public function medecin(): HasOne
    {
        return $this->hasOne(Medecin::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    // Vérifications de rôle
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMedecin(): bool
    {
        return $this->role === 'medecin';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    // ========== RELATIONS POUR LA MESSAGERIE ==========
    // Messages envoyés par l'utilisateur
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages reçus par l'utilisateur
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Messages non lus reçus
    public function unreadMessages()
    {
        return $this->receivedMessages()->where('is_read', false);
    }
}