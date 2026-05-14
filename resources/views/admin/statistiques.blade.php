@extends('layouts.app')

@section('header_icon', 'fa-chart-line')
@section('header_title', 'Statistiques')
@section('header_subtitle', 'Analyse et performance du centre')

@section('content')
<div class="space-y-8 mt-8">
    <!-- En-tête avec filtres -->
    <div class="flex flex-wrap items-center justify-between gap-4 p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord analytique</h1>
            <p class="text-sm text-gray-500">Visualisez les performances et les tendances</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
                <i class="fas fa-calendar-alt mr-2"></i> {{ now()->translatedFormat('F Y') }}
            </div>
            <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <!-- Filtres avancés -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-filter text-blue-600"></i>
            Filtrer les données
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                <select id="periodFilter" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="jour">Aujourd'hui</option>
                    <option value="semaine">Cette semaine</option>
                    <option value="mois" selected>Ce mois</option>
                    <option value="annee">Cette année</option>
                    <option value="personnalise">Personnalisé</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                <input type="date" id="dateDebut" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                <input type="date" id="dateFin" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Médecin</label>
                <select id="medecinFilter" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="">Tous les médecins</option>
                    @foreach($medecins ?? [] as $medecin)
                        <option value="{{ $medecin->id }}">Dr. {{ $medecin->user->name }} - {{ $medecin->specialite ?? 'Généraliste' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-4">
            <button id="applyFilters" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i> Appliquer
            </button>
            <button id="resetFilters" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition font-medium flex items-center gap-2">
                <i class="fas fa-undo-alt"></i> Réinitialiser
            </button>
        </div>
    </div>

    <!-- Cartes KPI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Médecins actifs</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-md text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalMedecins ?? 0 }}</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Patients</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPatients ?? 0 }}</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-amber-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Rendez-vous</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-check text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalRendezVous ?? 0 }}</p>
                <p class="text-xs text-orange-600 mt-1">{{ $rendezvousEnAttente ?? 0 }} en attente</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Consultations</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-notes-medical text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalConsultations ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i>
                    Évolution des rendez-vous
                </h3>
            </div>
            <div style="position: relative; height: 320px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-blue-600"></i>
                    Répartition par statut
                </h3>
            </div>
            <div style="position: relative; height: 320px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-6">
                <i class="fas fa-chart-bar text-blue-600"></i>
                Rendez-vous par jour (période sélectionnée)
            </h3>
            <div style="position: relative; height: 300px;">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    Top médecins
                </h3>
                <select id="topPeriod" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    <option value="mois">Ce mois</option>
                    <option value="annee">Cette année</option>
                    <option value="total">Total</option>
                </select>
            </div>
            <div class="space-y-3 max-h-[300px] overflow-y-auto" id="topMedecinsList">
                @forelse($topMedecins ?? [] as $medecin)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($medecin->user->name ?? 'D', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Dr. {{ $medecin->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $medecin->specialite ?? 'Généraliste' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-blue-600">{{ $medecin->consultations_count ?? 0 }}</p>
                        <p class="text-xs text-gray-400">consultations</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8">Aucune donnée disponible</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tableau détaillé des rendez-vous -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list-alt text-blue-600 mr-2"></i>
                Liste des rendez-vous
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Médecin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Spécialité</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date & heure</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($derniersRendezVous ?? [] as $rdv)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $rdv->patient->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">Dr. {{ $rdv->medecin->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $rdv->medecin->specialite ?? 'Médecine générale' }}</td>
                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }} à {{ $rdv->heure }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($rdv->statut) {
                                    'confirme' => 'bg-green-100 text-green-700',
                                    'en_attente' => 'bg-yellow-100 text-yellow-700',
                                    'annule' => 'bg-red-100 text-red-700',
                                    'termine' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                                $statusLabel = match($rdv->statut) {
                                    'confirme' => 'Confirmé',
                                    'en_attente' => 'En attente',
                                    'annule' => 'Annulé',
                                    'termine' => 'Terminé',
                                    default => $rdv->statut
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColor }}">{{ $statusLabel }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">Aucun rendez-vous trouvé pour la période sélectionnée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            {{ isset($derniersRendezVous) && method_exists($derniersRendezVous, 'links') ? $derniersRendezVous->links() : '' }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let activityChart, statusChart, dailyChart;

    document.addEventListener('DOMContentLoaded', function() {
        initFilters();
        initCharts();
    });

    function initFilters() {
        const periodFilter = document.getElementById('periodFilter');
        const dateDebut = document.getElementById('dateDebut');
        const dateFin = document.getElementById('dateFin');
        
        const today = new Date();
        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        dateDebut.value = formatDate(firstDayOfMonth);
        dateFin.value = formatDate(lastDayOfMonth);
        
        periodFilter.addEventListener('change', function() {
            const isCustom = this.value === 'personnalise';
            dateDebut.disabled = !isCustom;
            dateFin.disabled = !isCustom;
            if (!isCustom) {
                setDatesFromPeriod(this.value);
            }
        });
        
        dateDebut.disabled = true;
        dateFin.disabled = true;
        
        document.getElementById('applyFilters').addEventListener('click', applyFilters);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);
        document.getElementById('topPeriod')?.addEventListener('change', loadTopMedecins);
    }
    
    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }
    
    function setDatesFromPeriod(period) {
        const today = new Date();
        let debut, fin;
        
        switch(period) {
            case 'jour':
                debut = fin = today;
                break;
            case 'semaine':
                const startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay() + 1);
                debut = startOfWeek;
                fin = new Date(startOfWeek);
                fin.setDate(startOfWeek.getDate() + 6);
                break;
            case 'mois':
                debut = new Date(today.getFullYear(), today.getMonth(), 1);
                fin = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                break;
            case 'annee':
                debut = new Date(today.getFullYear(), 0, 1);
                fin = new Date(today.getFullYear(), 11, 31);
                break;
            default:
                return;
        }
        
        document.getElementById('dateDebut').value = formatDate(debut);
        document.getElementById('dateFin').value = formatDate(fin);
    }
    
    function applyFilters() {
        const params = new URLSearchParams();
        const period = document.getElementById('periodFilter').value;
        const medecinId = document.getElementById('medecinFilter').value;
        let dateDebut = document.getElementById('dateDebut').value;
        let dateFin = document.getElementById('dateFin').value;
        
        if (period !== 'personnalise') {
            setDatesFromPeriod(period);
            dateDebut = document.getElementById('dateDebut').value;
            dateFin = document.getElementById('dateFin').value;
        }
        
        if (dateDebut) params.append('date_debut', dateDebut);
        if (dateFin) params.append('date_fin', dateFin);
        if (medecinId) params.append('medecin_id', medecinId);
        
        window.location.href = window.location.pathname + '?' + params.toString();
    }
    
    function resetFilters() {
        window.location.href = window.location.pathname;
    }
    
    function loadTopMedecins() {
        const period = document.getElementById('topPeriod').value;
        fetch(`{{ url('/admin/statistiques/top-medecins') }}?period=${period}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('topMedecinsList');
                if (container && data.length) {
                    container.innerHTML = data.map(med => `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                    ${med.initial}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Dr. ${med.name}</p>
                                    <p class="text-xs text-gray-500">${med.specialite || 'Généraliste'}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-blue-600">${med.count}</p>
                                <p class="text-xs text-gray-400">consultations</p>
                            </div>
                        </div>
                    `).join('');
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
    
    function initCharts() {
        const monthlyData = @json($chartData['monthly'] ?? array_fill(0, 12, 0));
        const statusData = [
            {{ $statusCounts['confirme'] ?? 0 }},
            {{ $statusCounts['en_attente'] ?? 0 }},
            {{ $statusCounts['termine'] ?? 0 }},
            {{ $statusCounts['annule'] ?? 0 }}
        ];
        const dailyLabels = @json($dailyLabels ?? []);
        const dailyCounts = @json($dailyCounts ?? []);
        
        const activityCtx = document.getElementById('activityChart');
        if (activityCtx) {
            activityChart = new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Rendez-vous',
                        data: monthlyData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } } }
                }
            });
        }
        
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Confirmés', 'En attente', 'Terminés', 'Annulés'],
                    datasets: [{
                        data: statusData,
                        backgroundColor: ['#22c55e', '#f97316', '#3b82f6', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${context.raw} (${percent}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }
        
        const dailyCtx = document.getElementById('dailyChart');
        if (dailyCtx && dailyLabels.length > 0) {
            dailyChart = new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: 'Rendez-vous',
                        data: dailyCounts,
                        backgroundColor: '#3b82f6',
                        borderRadius: 8,
                        barPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#e2e8f0' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }
</script>
@endsection