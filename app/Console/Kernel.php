<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définit les commandes planifiées.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Envoi des rappels par email tous les jours à 8h00
        $schedule->command('rappel:send --type=email')
            ->dailyAt('08:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/rappel.log'));
        
        // Envoi des rappels par email aussi à 17h pour les RDV du lendemain matin
        $schedule->command('rappel:send --type=email')
            ->dailyAt('17:00')
            ->withoutOverlapping();
        
        // Notifications en base de données pour le tableau de bord
        $schedule->command('rappel:database')
            ->dailyAt('06:00')
            ->withoutOverlapping();
    }

    /**
     * Enregistre les commandes.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        
        require base_path('routes/console.php');
    }
}