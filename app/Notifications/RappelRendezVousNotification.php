<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\RendezVous;
use Carbon\Carbon;

class RappelRendezVousNotification extends Notification
{
    use Queueable;
    
    protected $rendezvous;
    protected $type; // 'email' ou 'database'

    public function __construct(RendezVous $rendezvous, $type = 'both')
    {
        $this->rendezvous = $rendezvous;
        $this->type = $type;
    }

    /**
     * Définit les canaux de notification
     */
    public function via($notifiable)
    {
        $channels = ['database'];
        
        if ($this->type === 'email' || $this->type === 'both') {
            $channels[] = 'mail';
        }
        
        if ($this->type === 'sms' || $this->type === 'both') {
            // $channels[] = 'nexmo'; // Décommenter si SMS configuré
        }
        
        return $channels;
    }

    /**
     * Envoi par email
     */
    public function toMail($notifiable)
    {
        $date = Carbon::parse($this->rendezvous->date)->format('d/m/Y');
        $heure = Carbon::parse($this->rendezvous->heure)->format('H:i');
        $medecinNom = $this->rendezvous->medecin->user->name ?? 'Médecin';
        $specialite = $this->rendezvous->medecin->specialite ?? 'Médecine générale';

        return (new MailMessage)
            ->subject('🔔 Rappel de rendez-vous - SanteRDV')
            ->greeting('Bonjour ' . $notifiable->name . ' 👋')
            ->line('Nous vous rappelons que vous avez un rendez-vous médical prévu :')
            ->line('')
            ->line('📅 **Date :** ' . $date)
            ->line('⏰ **Heure :** ' . $heure)
            ->line('👨‍⚕️ **Médecin :** Dr. ' . $medecinNom)
            ->line('🏥 **Spécialité :** ' . $specialite)
            ->line('📍 **Lieu :** Centre de santé de Ouando, Porto-Novo')
            ->line('')
            ->line('**Informations pratiques :**')
            ->line('• Arrivez 10 minutes avant votre rendez-vous')
            ->line('• Munissez-vous de votre pièce d\'identité')
            ->line('• Apportez vos examens médicaux antérieurs')
            ->line('')
            ->action('Voir mon rendez-vous', route('patient.rendezvous.show', $this->rendezvous->id))
            ->line('')
            ->line('En cas d\'empêchement, merci d\'annuler au moins 24h à l\'avance.')
            ->line('')
            ->salutation('Cordialement, L\'équipe SanteRDV');
    }

    /**
     * Envoi par base de données (notification dans l'application)
     */
    public function toDatabase($notifiable)
    {
        $date = Carbon::parse($this->rendezvous->date)->format('d/m/Y');
        $heure = Carbon::parse($this->rendezvous->heure)->format('H:i');
        
        return [
            'title' => '🔔 Rappel de rendez-vous',
            'message' => 'Rappel : vous avez un rendez-vous le ' . $date . ' à ' . $heure . ' avec le Dr ' . ($this->rendezvous->medecin->user->name ?? 'Médecin'),
            'rendezvous_id' => $this->rendezvous->id,
            'date' => $this->rendezvous->date,
            'heure' => $this->rendezvous->heure,
            'type' => 'rappel',
            'lien' => route('patient.rendezvous.show', $this->rendezvous->id),
        ];
    }

    /**
     * Format pour l'affichage dans l'application
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}