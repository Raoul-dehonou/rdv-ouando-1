<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@centre.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Médecin 1
        $medecinUser = User::create([
            'name' => 'Dr. Koffi',
            'email' => 'koffi@centre.com',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);
        Medecin::create([
            'user_id' => $medecinUser->id,
            'specialite' => 'Généraliste',
            'is_active' => true,
        ]);

        // Médecin 2
        $medecin2User = User::create([
            'name' => 'Dr. Awa',
            'email' => 'awa@centre.com',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);
        Medecin::create([
            'user_id' => $medecin2User->id,
            'specialite' => 'Pédiatrie',
            'is_active' => true,
        ]);

        // Patient 1
        $patientUser = User::create([
            'name' => 'Patient Test',
            'email' => 'patient@test.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        Patient::create([
            'user_id' => $patientUser->id,
            'telephone' => '12345678',
            'adresse' => 'Cotonou',
        ]);

        // Patient 2
        $patient2User = User::create([
            'name' => 'Marie',
            'email' => 'marie@test.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        Patient::create([
            'user_id' => $patient2User->id,
            'telephone' => '87654321',
            'adresse' => 'Porto-Novo',
        ]);
    }
}