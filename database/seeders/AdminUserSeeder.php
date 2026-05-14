<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Optionnel : créer un médecin de test
        $userMedecin = User::create([
            'name' => 'Dr Jean Test',
            'email' => 'medecin@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);
        Medecin::create([
            'user_id' => $userMedecin->id,
            'specialite' => 'Généraliste',
            'is_active' => true,
        ]);

        // Optionnel : créer un patient de test
        $userPatient = User::create([
            'name' => 'Patient Test',
            'email' => 'patient@santerdv.bj',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        Patient::create([
            'user_id' => $userPatient->id,
            'telephone' => '0102030405',
            'adresse' => 'Test adresse',
        ]);
    }
}