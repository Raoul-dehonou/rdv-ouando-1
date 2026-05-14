@extends('layouts.app')

@section('header_icon', 'fa-ambulance')
@section('header_title', 'Alertes urgence')
@section('header_subtitle', 'Gestion des signalements d\'urgence')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Alertes urgence</h1>
                <p class="text-sm text-gray-500">Gestion des signalements d'urgence</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
                <i class="fas fa-bell mr-2"></i> En attente : {{ $alertes->where('traitee', false)->count() }}
            </div>
            <div class="px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-medium border border-green-200">
                <i class="fas fa-check-circle mr-2"></i> Traitées : {{ $alertes->where('traitee', true)->count() }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Total alertes</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $alertes->total() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-rose-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">En attente</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-red-600">{{ $alertes->where('traitee', false)->count() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Traitées</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ $alertes->where('traitee', true)->count() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-amber-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Taux de résolution</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-percent text-white text-lg"></i>
                    </div>
                </div>
                @php
                    $total = $alertes->total();
                    $traitees = $alertes->where('traitee', true)->count();
                    $taux = $total > 0 ? round(($traitees / $total) * 100) : 0;
                @endphp
                <p class="text-3xl font-bold text-gray-800">{{ $taux }}%</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list text-blue-600 mr-2"></i>
                Liste des signalements
            </h3>
            <div class="flex gap-2">
                <select class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option>Tous</option>
                    <option>En attente</option>
                    <option>Traitées</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($alertes as $alerte)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $alerte->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($alerte->created_at)->format('d/m/Y') }}</span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($alerte->created_at)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($alerte->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $alerte->nom }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="tel:{{ $alerte->telephone }}" class="flex items-center gap-2 text-blue-600 hover:underline">
                                <i class="fas fa-phone-alt text-sm"></i>
                                <span class="text-sm">{{ $alerte->telephone }}</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $alerte->description }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($alerte->traitee)
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Traitée</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full animate-pulse">En attente</span>
                            @endif
                        </tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if(!$alerte->traitee)
                                    <form action="{{ route('admin.urgences.traitee', $alerte->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg text-sm font-medium transition-all duration-300 flex items-center gap-1">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            <span>Traiter</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-sm flex items-center gap-1">
                                        <i class="fas fa-check-circle text-xs"></i>
                                        <span>Traitée</span>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-bell-slash text-4xl text-blue-600"></i>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">Aucune alerte d'urgence</p>
                                <p class="text-gray-400 text-sm mt-1">Toutes les alertes sont traitées</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($alertes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            {{ $alertes->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    const filterSelect = document.querySelector('select');
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(6)');
                if (statusCell) {
                    const isTraitee = statusCell.innerText.includes('Traitée');
                    if (status === 'Tous') {
                        row.style.display = '';
                    } else if (status === 'En attente' && !isTraitee) {
                        row.style.display = '';
                    } else if (status === 'Traitées' && isTraitee) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }
</script>
@endsection