<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RendezVous;

class NouveauRendezVous extends Notification
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
            'title' => 'Nouvelle demande de rendez-vous',
            'message' => 'Un patient a demandé un rendez-vous le ' . $this->rendezvous->date->format('d/m/Y') . ' à ' . $this->rendezvous->heure,
            'rendezvous_id' => $this->rendezvous->id,
        ];
    }
}