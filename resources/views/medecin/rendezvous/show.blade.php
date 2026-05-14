@extends('layouts.app')

@section('title', 'Détails rendez-vous')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-check text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Détails du rendez-vous</h1>
                <p class="text-sm text-gray-500">Informations complètes</p>
            </div>
        </div>
        <a href="{{ route('medecin.rendez-vous.index') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Rendez-vous
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label class="text-sm text-gray-500">Patient</label><p class="font-semibold">{{ $rendezvous->patient->user->name }}</p></div>
                <div><label class="text-sm text-gray-500">Email patient</label><p>{{ $rendezvous->patient->user->email }}</p></div>
                <div><label class="text-sm text-gray-500">Date</label><p>{{ $rendezvous->date->format('d/m/Y') }}</p></div>
                <div><label class="text-sm text-gray-500">Heure</label><p>{{ $rendezvous->heure }}</p></div>
                <div><label class="text-sm text-gray-500">Motif</label><p>{{ $rendezvous->motif ?? '-' }}</p></div>
                <div><label class="text-sm text-gray-500">Statut</label>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $rendezvous->statut == 'confirme' ? 'bg-green-100 text-green-700' : ($rendezvous->statut == 'termine' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst($rendezvous->statut) }}
                    </span>
                </div>
                <div class="md:col-span-2"><label class="text-sm text-gray-500">Notes</label><p class="text-gray-700">{{ $rendezvous->notes ?? 'Aucune note' }}</p></div>
            </div>
            <div class="flex justify-end mt-6">
                <form action="{{ route('medecin.rendez-vous.update-statut', $rendezvous) }}" method="POST" class="inline">
                    @csrf
                    <select name="statut" class="border rounded-lg px-3 py-2">
                        <option value="en_attente" {{ $rendezvous->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirme" {{ $rendezvous->statut == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                        <option value="termine" {{ $rendezvous->statut == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="annule" {{ $rendezvous->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    <button type="submit" class="ml-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg">Modifier statut</button>
                </form>
                @if($rendezvous->statut == 'termine')
                    <a href="{{ route('medecin.consultations.create', $rendezvous) }}" class="ml-2 px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg">
                        <i class="fas fa-notes-medical mr-1"></i> Ajouter consultation
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection