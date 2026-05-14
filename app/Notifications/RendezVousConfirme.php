<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RendezVous;

class RendezVousConfirme extends Notification
{
    use Queueable;

    protected $rendezvous;

    public function __construct(RendezVous $rendezvous)
    {
        $this->rendezvous = $rendezvous;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Rendez-vous confirmé',
            'message' => 'Votre rendez-vous du ' . $this->rendezvous->date->format('d/m/Y') . ' à ' . $this->rendezvous->heure . ' a été confirmé par le médecin.',
            'rendezvous_id' => $this->rendezvous->id,
        ];
    }
}