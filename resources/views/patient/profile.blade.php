@extends('layouts.app')

@section('header_icon', 'fa-user-circle')
@section('header_title', 'Mon Profil')

@section('content')
<div class="space-y-8 mt-8">
    <!-- Informations personnelles -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold"><i class="fas fa-user-circle text-teal-600 mr-2"></i>Mes informations</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('patient.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label>Nom complet</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone', $patient->telephone ?? '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Date de naissance</label><input type="date" name="date_naissance" value="{{ old('date_naissance', $patient->date_naissance ? $patient->date_naissance->format('Y-m-d') : '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div class="md:col-span-2"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse', $patient->adresse ?? '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div class="md:col-span-2"><label>Contact d'urgence</label><input type="text" name="contact_urgence" value="{{ old('contact_urgence', $patient->contact_urgence ?? '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                </div>
                <div class="flex justify-end mt-6"><button type="submit" class="px-6 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg">Mettre à jour</button></div>
            </form>
        </div>
    </div>

    <!-- Changer mot de passe -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold"><i class="fas fa-lock text-orange-600 mr-2"></i>Changer mot de passe</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('patient.profile.update-password') }}" method="POST">
                @csrf @method('PUT')
                <div><label>Mot de passe actuel</label><input type="password" name="current_password" required class="w-full border rounded-lg px-4 py-2 mb-4"></div>
                <div><label>Nouveau mot de passe</label><input type="password" name="password" required class="w-full border rounded-lg px-4 py-2 mb-4"></div>
                <div><label>Confirmation</label><input type="password" name="password_confirmation" required class="w-full border rounded-lg px-4 py-2"></div>
                <div class="flex justify-end mt-6"><button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg">Changer</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
