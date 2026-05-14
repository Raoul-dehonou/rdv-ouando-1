@extends('layouts.app')


@section('header_icon', 'fa-calendar-check')
@section('header_title', 'Détails patient')
@section('header_subtitle', 'Informations')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-50">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-injured text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-700">Plus d'informations</h1>
                <p class="text-sm text-gray-500">{{ $patient->user->name }}</p>
            </div>
        </div>
        <a href="{{ route('medecin.patients.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">Retour</a>
    </div>

    <!-- Infos personnelles -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800"><i class="fas fa-user text-green-600 mr-2"></i>Informations personnelles</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label class="text-sm text-gray-500">Nom complet</label><p class="font-semibold">{{ $patient->user->name }}</p></div>
                <div><label class="text-sm text-gray-500">Email</label><p>{{ $patient->user->email }}</p></div>
                <div><label class="text-sm text-gray-500">Téléphone</label><p>{{ $patient->telephone ?? '-' }}</p></div>
                <div><label class="text-sm text-gray-500">Date de naissance</label><p>{{ $patient->date_naissance ? $patient->date_naissance->format('d/m/Y') : '-' }}</p></div>
                <div><label class="text-sm text-gray-500">Adresse</label><p>{{ $patient->adresse ?? '-' }}</p></div>
                <div><label class="text-sm text-gray-500">Contact urgence</label><p>{{ $patient->contact_urgence ?? '-' }}</p></div>
            </div>
        </div>
    </div>

    <!-- Historique des consultations -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800"><i class="fas fa-history text-blue-600 mr-2"></i>Historique des consultations</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Diagnostic</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ordonnance</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patient->consultations as $consultation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">{{ $consultation->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($consultation->diagnostic, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($consultation->prescription, 50) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('medecin.consultations.show', $consultation) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">Aucune consultation enregistrée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection