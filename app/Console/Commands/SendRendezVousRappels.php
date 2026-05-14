<?php

namespace App\Console\Commands;

use App\Models\RendezVous;
use App\Notifications\RappelRendezVousNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendRendezVousRappels extends Command
{
    protected $signature = 'rappel:send {--type=both : email, sms, or both}';
    protected $description = 'Envoie les rappels de rendez-vous aux patients (J-1 et J-0)';

    public function handle()
    {
        $type = $this->option('type');
        $now = Carbon::now();
        
        // Rendez-vous du jour (J-0)
        $todayAppointments = RendezVous::whereDate('date', $now->toDateString())
            ->where('statut', 'confirme')
            ->with(['patient.user', 'medecin.user'])
            ->get();
        
        // Rendez-vous de demain (J-1)
        $tomorrowAppointments = RendezVous::whereDate('date', $now->copy()->addDay()->toDateString())
            ->where('statut', 'confirme')
            ->with(['patient.user', 'medecin.user'])
            ->get();
        
        $count = 0;
        
        // Envoi des rappels pour aujourd'hui (rappel matinal)
        foreach ($todayAppointments as $rdv) {
            $heureRdv = Carbon::parse($rdv->heure);
            $heureActuelle = Carbon::now();
            
            // Envoyer le rappel seulement si l'heure du RDV est dans plus de 2 heures
            if ($heureActuelle->diffInHours($heureRdv) >= 2) {
                $this->sendRappel($rdv, $type);
                $count++;
            }
        }
        
        // Envoi des rappels pour demain
        foreach ($tomorrowAppointments as $rdv) {
            $this->sendRappel($rdv, $type);
            $count++;
        }
        
        $this->info("{$count} rappel(s) envoyé(s) avec succès !");
        Log::info("Rappels envoyés : {$count} rendez-vous notifiés");
        
        return Command::SUCCESS;
    }
    
    private function sendRappel($rendezvous, $type)
    {
        try {
            $patient = $rendezvous->patient->user;
            
            if (!$patient) {
                return;
            }
            
            // Envoi par email
            if ($type === 'email' || $type === 'both') {
                $patient->notify(new RappelRendezVousNotification($rendezvous, 'email'));
                $this->line("Email envoyé à : {$patient->email}");
                Log::info("Rappel email envoyé à {$patient->email} pour le RDV du " . $rendezvous->date);
            }
            
            // Envoi par SMS (si configuré)
            if ($type === 'sms' || $type === 'both') {
                $this->sendSms($patient, $rendezvous);
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur envoi rappel: ' . $e->getMessage());
            $this->error('Erreur: ' . $e->getMessage());
        }
    }
    
    private function sendSms($patient, $rendezvous)
    {
        // Configuration SMS avec Vonage (Nexmo) ou Twilio
        // Cette méthode sera implémentée plus tard avec un service SMS
        
        $date = Carbon::parse($rendezvous->date)->format('d/m/Y');
        $heure = Carbon::parse($rendezvous->heure)->format('H:i');
        
        $message = "SanteRDV: Rappel - Votre rendez-vous avec Dr. {$rendezvous->medecin->user->name} le {$date} à {$heure}. Centre de santé de Ouando.";
        
        // À implémenter avec l'API SMS de votre choix
        // SmsService::send($patient->telephone, $message);
        
        Log::info("SMS à envoyer à {$patient->telephone}: {$message}");
    }
}