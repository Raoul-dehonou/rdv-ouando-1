<?php

namespace App\Notifications;

use App\Models\AlerteUrgence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleAlerteUrgence extends Notification
{
    use Queueable;

    protected $alerte;

    /**
     * Create a new notification instance.
     */
    public function __construct(AlerteUrgence $alerte)
    {
        $this->alerte = $alerte;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🆘 Nouvelle alerte urgence - SanteRDV')
            ->greeting('Bonjour,')
            ->line('Une nouvelle alerte urgence a été soumise sur la plateforme SanteRDV.')
            ->line('**Détails de l’alerte :**')
            ->line("- **Nom :** {$this->alerte->nom}")
            ->line("- **Téléphone :** {$this->alerte->telephone}")
            ->line("- **Description :** {$this->alerte->description}")
            ->action('Voir l’alerte', url('/admin/urgences'))
            ->line('Veuillez prendre connaissance et contacter la personne rapidement.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'alerte_id' => $this->alerte->id,
            'nom' => $this->alerte->nom,
            'telephone' => $this->alerte->telephone,
            'message' => 'Nouvelle alerte urgence reçue',
        ];
    }
}