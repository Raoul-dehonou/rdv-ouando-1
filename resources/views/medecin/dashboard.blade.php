@extends('layouts.app')

@section('header_icon', 'fa-chart-line')
@section('header_title', 'Tableau de bord')
@section('header_subtitle', 'Bienvenue, Dr. ' . Auth::user()->name)

@section('content')
<div class="space-y-8 mt-8">
    <!-- En-tête -->
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-50 ">
        <div class="flex items-center space-x-4 ">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-800">Vue d'ensemble</p>
                
            </div>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium border border-blue-200">
            <i class="far fa-calendar-alt mr-2"></i> {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Carte Rendez-vous aujourd'hui -->
        <div class="group relative bg-blue-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Aujourd'hui</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-day text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ $rendezVousAujourdhui ?? 0 }}</p>
                <p class="text-xs text-blue-100 mt-2">Rendez-vous programmés</p>
            </div>
        </div>

        <!-- Carte Patients vus ce mois -->
        <div class="group relative bg-green-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-semibold text-green-100 uppercase tracking-wider">Patients</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ $patientsVusMois ?? 0 }}</p>
                <p class="text-xs text-green-100 mt-2">Consultations ce mois</p>
            </div>
        </div>

        <!-- Carte Taux de satisfaction -->
       <div class="group relative bg-red-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-semibold text-red-100 uppercase tracking-wider">Satisfaction</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-star text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ number_format($satisfaction ?? 0, 1) }}<span class="text-lg font-normal text-yellow-100">/5</span></p>
                <p class="text-xs text-yellow-100 mt-2">Note moyenne des patients</p>
                <div class="mt-3 flex items-center text-xs text-white">
                    @php
                        $fullStars = floor($satisfaction ?? 0);
                        $halfStar = ($satisfaction ?? 0) - $fullStars >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                    @endphp
                    @for($i = 0; $i < $fullStars; $i++) <i class="fas fa-star text-white text-[10px]"></i> @endfor
                    @if($halfStar) <i class="fas fa-star-half-alt text-white text-[10px]"></i> @endif
                    @for($i = 0; $i < $emptyStars; $i++) <i class="far fa-star text-white text-[10px]"></i> @endfor
                </div>
            </div>
        </div>

        <!-- Carte Prochain rendez-vous -->
         <div class="group relative bg-orange-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-semibold text-orange-100 uppercase tracking-wider">Prochain RDV</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-hourglass-half text-white text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col">
                    @if($prochainRendezVous)
                        <p class="text-lg font-semibold text-white">{{ $prochainRendezVous->heure }}</p>
                        <p class="text-sm text-purple-100">{{ $prochainRendezVous->patient->user->name ?? 'Patient' }}</p>
                    @else
                        <p class="text-lg font-semibold text-purple-200">--:--</p>
                        <p class="text-sm text-purple-200">Aucun rendez-vous</p>
                    @endif
                </div>
                @if($prochainRendezVous && $minutesRestantes > 0)
                <div class="mt-3 flex items-center text-xs text-purple-200">
                    <i class="fas fa-clock mr-1"></i> Dans {{ $minutesRestantes }} minutes
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique d'activité mensuelle -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-[#1a6fff]"></i>
                    Évolution des consultations
                </h3>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Répartition par type de consultation -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-[#1a6fff]"></i>
                    Répartition des consultations
                </h3>
            </div>
            <div style="position: relative; height: 260px;">
                <canvas id="typeChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#1a6fff] rounded-full"></div>
                    <span class="text-xs text-gray-600">Consultations ({{ $consultationsGenerales ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#0d5ae0] rounded-full"></div>
                    <span class="text-xs text-gray-600">Téléconsultations ({{ $teleconsultations ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#60a5fa] rounded-full"></div>
                    <span class="text-xs text-gray-600">Consultations suivi ({{ $consultationsSuivi ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#93c5fd] rounded-full"></div>
                    <span class="text-xs text-gray-600">Urgences ({{ $urgences ?? 0 }})</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique des jours de la semaine -->
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-bar text-[#1a6fff]"></i>
                Consultations par jour de la semaine
            </h3>
        </div>
        <div style="position: relative; height: 280px;">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Rendez-vous du jour -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-calendar-alt text-[#1a6fff] mr-2"></i>
                Rendez-vous du jour
            </h2>
            <span class="text-xs text-gray-500">{{ now()->translatedFormat('l d F Y') }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rendezVousDuJour ?? [] as $rdv)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $rdv->heure }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($rdv->patient->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $rdv->patient->user->name ?? 'Inconnu' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $typeClass = match($rdv->type ?? 'Consultation') {
                                    'Consultation' => 'bg-blue-100 text-blue-700',
                                    'Téléconsultation' => 'bg-purple-100 text-purple-700',
                                    'Consultation suivi' => 'bg-green-100 text-green-700',
                                    'Urgence' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $typeClass }}">{{ $rdv->type ?? 'Consultation' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = match($rdv->statut) {
                                    'confirmé' => 'bg-green-100 text-green-700',
                                    'en attente' => 'bg-orange-100 text-orange-700',
                                    'annulé' => 'bg-red-100 text-red-700',
                                    'terminé' => 'bg-gray-100 text-gray-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $badgeClass }}">{{ ucfirst($rdv->statut) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('medecin.consultations.create', $rdv) }}" class="px-3 py-1.5 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white rounded-lg text-xs font-medium transition-all duration-300">
                                <i class="fas fa-stethoscope mr-1"></i> Consulter
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-calendar-week text-3xl mb-2 opacity-50"></i>
                            <p>Aucun rendez-vous prévu aujourd'hui</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique d'activité mensuelle
    const consultationsParMois = @json($consultationsParMois ?? array_fill(0, 12, 0));
    
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Consultations',
                data: consultationsParMois,
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
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b' } },
            scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' }, ticks: { stepSize: 10 } }, x: { grid: { display: false } } }
        }
    });

    // Graphique des types de consultation
    const ctx2 = document.getElementById('typeChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Consultations', 'Téléconsultations', 'Consultations suivi', 'Urgences'],
            datasets: [{
                data: [
                    {{ $consultationsGenerales ?? 0 }},
                    {{ $teleconsultations ?? 0 }},
                    {{ $consultationsSuivi ?? 0 }},
                    {{ $urgences ?? 0 }}
                ],
                backgroundColor: ['#1a6fff', '#0d5ae0', '#60a5fa', '#93c5fd'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b' } },
            cutout: '65%'
        }
    });

    // Graphique hebdomadaire
    const consultationsParJour = @json($consultationsParJour ?? array_fill(0, 7, 0));
    
    const ctx3 = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            datasets: [{
                label: 'Consultations',
                data: consultationsParJour,
                backgroundColor: '#1a6fff',
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b' } },
            scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } }, x: { grid: { display: false } } }
        }
    });
</script>
@endsection