<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RendezVous;
use App\Notifications\RappelRendezVousNotification;
use Carbon\Carbon;

class SendRappelRendezVous extends Command
{
    protected $signature = 'rappel:rendezvous';
    protected $description = 'Envoie un rappel aux patients pour les rendez-vous du lendemain';

    public function handle()
    {
        $demain = Carbon::tomorrow()->toDateString();
        $rendezvous = RendezVous::whereDate('date', $demain)
            ->where('statut', 'confirme')
            ->with('patient.user')
            ->get();

        foreach ($rendezvous as $rdv) {
            $rdv->patient->user->notify(new RappelRendezVousNotification($rdv));
            $this->info("Rappel envoyé pour {$rdv->patient->user->name} - {$rdv->date} {$rdv->heure}");
        }

        $this->info("Rappels envoyés pour " . $rendezvous->count() . " rendez-vous.");
    }
}