@extends('layouts.app')

@section('header_icon', 'fa-calendar-alt')
@section('header_title', 'Gestion des rendez-vous')
@section('header_subtitle', 'Planification et suivi')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rendez-vous</h1>
                <p class="text-sm text-gray-500">Liste et gestion des rendez-vous</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
                <i class="fas fa-calendar-week mr-2"></i> Total : {{ $rendezVous->total() ?? 0 }}
            </div>
            <a href="{{ route('admin.rendez-vous.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium flex items-center gap-2 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Nouveau rendez-vous</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Total rendez-vous</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $rendezVous->total() ?? 0 }}</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Confirmés</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $rendezVous->where('statut', 'confirme')->count() ?? 0 }}</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-amber-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">En attente</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $rendezVous->where('statut', 'en_attente')->count() ?? 0 }}</p>
            </div>
        </div>
        
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Aujourd'hui</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-day text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $rendezVous->where('date', now()->toDateString())->count() ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Médecin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date & heure</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rendezVous as $rdv)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $rdv->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($rdv->patient->user->name ?? 'N/A', 0, 1)) }}
                                </div>
                                <p class="font-semibold text-gray-800">{{ $rdv->patient->user->name ?? 'N/A' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-800">Dr. {{ $rdv->medecin->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $rdv->medecin->specialite ?? 'Médecine générale' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-800">{{ $rdv->date ? \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') : 'N/A' }}</span>
                                <span class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> {{ $rdv->heure }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statutClass = match($rdv->statut) {
                                    'confirme' => 'bg-green-100 text-green-700',
                                    'en_attente' => 'bg-yellow-100 text-yellow-700',
                                    'annule' => 'bg-red-100 text-red-700',
                                    'termine' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                                $statutLabel = match($rdv->statut) {
                                    'confirme' => 'Confirmé',
                                    'en_attente' => 'En attente',
                                    'annule' => 'Annulé',
                                    'termine' => 'Terminé',
                                    default => $rdv->statut
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statutClass }}">{{ $statutLabel }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.rendez-vous.destroy', $rdv->id) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="delete-btn w-8 h-8 flex items-center justify-center text-red-600 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition" data-name="{{ $rdv->patient->user->name ?? 'ce patient' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">Aucun rendez-vous trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $rendezVous->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Confirmation',
                text: `Supprimer le rendez-vous de ${this.dataset.name} ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#22C55E',
                confirmButtonText: 'Oui',
                cancelButtonText: 'Annuler'
            }).then(res => res.isConfirmed && form.submit());
        });
    });
</script>
@endsection