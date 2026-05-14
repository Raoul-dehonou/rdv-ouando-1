@extends('layouts.app')

@section('header_icon', 'fa-calendar-check')
@section('header_title', 'Mes rendez-vous')
@section('header_subtitle', 'Gérez vos consultations')

@section('content')
<div class="space-y-8 mt-8">
    <!-- En-tête -->
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4 ">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-800">Liste de tous vos rendez-vous</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
            <i class="fas fa-chart-line mr-2"></i> Total : {{ $rendezvous->total() }}
        </div>
    </div>

    <!-- Filtres rapides -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-filter text-gray-600 mr-2"></i>
                Filtrer
            </h2>
        </div>
        <div class="p-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Du</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Au</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="statut" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirme" {{ request('statut') == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                        <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Filtrer</button>
                    <a href="{{ route('medecin.rendez-vous.index') }}" class="ml-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des rendez-vous -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Motif</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rendezvous as $rdv)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">{{ $rdv->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $rdv->heure }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $rdv->patient->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->motif ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $rdv->statut == 'confirme' ? 'bg-green-100 text-green-700' : ($rdv->statut == 'termine' ? 'bg-blue-100 text-blue-700' : ($rdv->statut == 'annule' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                {{ ucfirst($rdv->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('medecin.rendez-vous.show', $rdv) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Aucun rendez-vous trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $rendezvous->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection