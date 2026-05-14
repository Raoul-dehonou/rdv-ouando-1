<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un administrateur
        $admin = User::create([
            'name' => 'Admin SanteRDV',
            'email' => 'admin@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Créer un médecin
        $medecinUser = User::create([
            'name' => 'Dr Jean Dupont',
            'email' => 'medecin@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);

        $medecin = Medecin::create([
            'user_id' => $medecinUser->id,
            'specialite' => 'Généraliste',
            'is_active' => true,
        ]);

        // Créer un patient
        $patientUser = User::create([
            'name' => 'Patient Test',
            'email' => 'patient@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'telephone' => '0102030405',
            'adresse' => 'Cotonou, Bénin',
            'date_naissance' => '1990-01-01',
        ]);

        // Optionnel : ajouter des disponibilités pour le médecin
        \App\Models\Disponibilite::create([
            'medecin_id' => $medecin->id,
            'date' => now()->addDay(),
            'heure_debut' => '09:00',
            'heure_fin' => '12:00',
            'duree' => 30,
        ]);

        \App\Models\Disponibilite::create([
            'medecin_id' => $medecin->id,
            'date' => now()->addDay(),
            'heure_debut' => '14:00',
            'heure_fin' => '17:00',
            'duree' => 30,
        ]);

        $this->command->info('Seeders exécutés avec succès !');
        $this->command->info('Admin : admin@santerdv.bj / password');
        $this->command->info('Médecin : medecin@santerdv.bj / password');
        $this->command->info('Patient : patient@santerdv.bj / password');
    }
}