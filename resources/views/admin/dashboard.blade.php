@extends('layouts.app')

@section('title', 'Tableau de bord - Administration')

@section('content')
<div class="space-y-5">
    
    <!-- Espace avant Vue d'ensemble -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-800">Vue d'ensemble</h2>
        <p class="text-sm text-gray-500 mt-1">Statistiques et indicateurs clés de votre plateforme</p>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Carte Médecins (Bleu clair) -->
        <div class="relative overflow-hidden bg-blue-600 rounded-2xl p-6 text-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-white/80">Médecins</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-md text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $medecinsCount ?? 0 }}</p>
                <div class="mt-3 flex items-center text-xs text-white/70">
                    <i class="fas fa-check-circle mr-1 text-green-300"></i>
                    {{ $medecinsActifs ?? 0 }} actifs
                </div>
            </div>
        </div>

        <!-- Carte Patients (Vert clair) -->
        <div class="relative overflow-hidden bg-green-600 rounded-2xl p-6 text-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-white/80">Patients</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $patientsCount ?? 0 }}</p>
                <div class="mt-3 flex items-center text-xs text-white/70">
                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                    +{{ $nouveauxPatients ?? 0 }} ce mois
                </div>
            </div>
        </div>

        <!-- Carte Rendez-vous (Orange) -->
        <div class="relative overflow-hidden bg-orange-500 rounded-2xl p-6 text-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-white/80">Rendez-vous</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $rendezVousCount ?? 0 }}</p>
                <div class="mt-3 flex items-center text-xs text-white/70">
                    <i class="fas fa-calendar-day mr-1"></i>
                    {{ $rendezVousAujourdhui ?? 0 }} aujourd'hui
                </div>
                @if($prochainRdvHeure ?? false)
                <div class="mt-2 text-xs text-white/80">
                    <i class="fas fa-clock mr-1"></i> Prochain : {{ $prochainRdvHeure }}
                </div>
                @endif
            </div>
        </div>

        <!-- Carte Taux d'occupation (Violet) -->
        <div class="relative overflow-hidden bg-purple-500 rounded-2xl p-6 text-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-white/80">Taux d'occupation</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $tauxOccupation ?? 0 }}<span class="text-lg font-normal">%</span></p>
                <div class="mt-3 flex items-center text-xs text-white/70">
                    <i class="fas fa-chart-line mr-1"></i>
                    +{{ $variationOccupation ?? 0 }}% vs mois dernier
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique d'activité -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chart-line text-[#1a6fff] mr-2"></i>
                Évolution des rendez-vous
            </h3>
        </div>
        <div class="p-6">
            <canvas id="activityChart" height="80"></canvas>
        </div>
    </div>

    <!-- Derniers rendez-vous et Alertes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Derniers rendez-vous -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center flex-wrap gap-2">
                <h3 class="font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-alt text-[#1a6fff] mr-2"></i>
                    Derniers rendez-vous
                </h3>
                <select id="filterStatut" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-[#1a6fff] focus:border-[#1a6fff]">
                    <option value="">Tous les statuts</option>
                    <option value="confirmé">Confirmé</option>
                    <option value="en attente">En attente</option>
                    <option value="terminé">Terminé</option>
                    <option value="annulé">Annulé</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Médecin</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody id="rdvTableBody" class="divide-y divide-gray-100">
                        @forelse($derniersRendezVous ?? [] as $rdv)
                        <tr class="hover:bg-gray-50 transition rdv-row" data-statut="{{ $rdv->statut }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($rdv->patient->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $rdv->patient->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->medecin->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }} {{ $rdv->heure }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeClass = match($rdv->statut) {
                                        'confirmé' => 'bg-green-100 text-green-700',
                                        'en attente' => 'bg-orange-100 text-orange-700',
                                        'annulé' => 'bg-red-100 text-red-700',
                                        'terminé' => 'bg-blue-100 text-blue-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $badgeClass }}">{{ ucfirst($rdv->statut) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Aucun rendez-vous récent</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                <a href="{{ route('admin.rendez-vous.index') }}" class="text-sm text-[#1a6fff] hover:underline flex items-center gap-1">
                    Voir tous les rendez-vous <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Alertes récentes -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-bell text-[#1a6fff] mr-2"></i>
                    Alertes récentes
                </h3>
                @php
                    $nbAlertesNonTraitees = isset($alertesNonTraitees) ? $alertesNonTraitees->count() : 0;
                @endphp
                @if($nbAlertesNonTraitees > 0)
                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full animate-pulse">{{ $nbAlertesNonTraitees }} en attente</span>
                @endif
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($alertesRecentes ?? [] as $alerte)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-ambulance text-red-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-semibold text-gray-800 text-sm">{{ $alerte->nom }}</p>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($alerte->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $alerte->description }}</p>
                            <div class="flex items-center gap-3">
                                <a href="tel:{{ $alerte->telephone }}" class="text-xs text-[#1a6fff] hover:underline flex items-center gap-1">
                                    <i class="fas fa-phone-alt text-[10px]"></i> {{ $alerte->telephone }}
                                </a>
                                @if(!$alerte->traitee)
                                    <form action="{{ route('admin.urgences.traitee', $alerte->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-green-600 hover:text-green-700 flex items-center gap-1">
                                            <i class="fas fa-check-circle text-[10px]"></i> Marquer traitée
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-400">
                    <i class="fas fa-bell-slash text-3xl mb-2 opacity-50"></i>
                    <p class="text-sm">Aucune alerte récente</p>
                </div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                <a href="{{ route('admin.urgences.index') }}" class="text-sm text-[#1a6fff] hover:underline flex items-center gap-1">
                    Voir toutes les alertes <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Rendez-vous',
                data: {{ json_encode($chartData ?? [12, 19, 15, 17, 14, 23, 21, 18, 25, 22, 20, 18]) }},
                borderColor: '#1a6fff',
                backgroundColor: 'rgba(26, 111, 255, 0.05)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1a6fff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleColor: '#fff', bodyColor: '#cbd5e1', padding: 10, borderColor: '#1a6fff', borderWidth: 2 } },
            scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0', drawBorder: false }, ticks: { stepSize: 10 } }, x: { grid: { display: false } } }
        }
    });
    
    const filterStatut = document.getElementById('filterStatut');
    const rdvRows = document.querySelectorAll('.rdv-row');
    if (filterStatut) {
        filterStatut.addEventListener('change', function() {
            const selectedStatut = this.value;
            rdvRows.forEach(row => {
                const rowStatut = row.getAttribute('data-statut');
                row.style.display = (!selectedStatut || rowStatut === selectedStatut) ? '' : 'none';
            });
        });
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection