@extends('layouts.app')

@section('header_icon', 'fa-user-md')
@section('header_title', 'Mon Profil')


@section('content')
<div class="space-y-8 mt-8">
    <!-- Infos personnelles -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mt-8">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold"><i class="fas fa-user-md text-teal-600 mr-2"></i>Mes informations</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('medecin.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label>Nom complet</label><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Email</label><input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Spécialité</label><input type="text" name="specialite" value="{{ old('specialite', auth()->user()->medecin->specialite ?? '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                    <div><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone', auth()->user()->medecin->telephone ?? '') }}" class="w-full border rounded-lg px-4 py-2"></div>
                </div>
                <div class="flex justify-end mt-6"><button type="submit" class="px-6 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg">Mettre à jour</button></div>
            </form>
        </div>
    </div>

    <!-- Changer mot de passe -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white"><h2 class="font-semibold"><i class="fas fa-lock text-orange-600 mr-2"></i>Changer mot de passe</h2></div>
        <div class="p-6">
            <form action="{{ route('medecin.profile.update-password') }}" method="POST">
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
