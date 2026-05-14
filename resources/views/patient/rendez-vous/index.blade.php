@extends('layouts.app')

@section('header_icon', 'fa-calendar-check')
@section('header_title', 'Mes rendez-vous')
@section('header_subtitle', 'Suivez vos consultations à venir')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100 mt-8">
        <div class="flex items-center space-x-4 ">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-700">Gestion de vos consultations à venir</h1>
               
            </div>
        </div>
        <a href="{{ route('patient.rendez-vous.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Prendre rendez-vous</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-calendar-day text-blue-600"></i>
                Rendez-vous à venir
            </h2>
        </div>
        
        @if($rendezvous->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($rendezvous as $rdv)
                <div class="p-5 hover:bg-gray-50 transition">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex flex-col items-center justify-center">
                                <span class="text-lg font-bold text-blue-600">{{ \Carbon\Carbon::parse($rdv->date)->format('d') }}</span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rdv->date)->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-lg font-bold text-gray-800">Dr. {{ $rdv->medecin->user->name }}</h3>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $rdv->statut == 'confirme' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $rdv->statut == 'confirme' ? '✓ Confirmé' : '⏳ En attente' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-stethoscope text-blue-600 mr-1"></i> {{ $rdv->medecin->specialite ?? 'Médecine générale' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('patient.rendez-vous.show', $rdv) }}" class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-eye mr-1"></i> Détails
                            </a>
                            @if($rdv->statut != 'annule')
                            <form action="{{ route('patient.rendez-vous.destroy', $rdv) }}" method="POST" class="inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-btn px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    <i class="fas fa-calendar-times mr-1"></i> Annuler
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-blue-600 w-5"></i>
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($rdv->date)->translatedFormat('l d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-blue-600 w-5"></i>
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($rdv->heure)->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-blue-600 w-5"></i>
                            <span class="text-sm text-gray-600">Centre de santé de Ouando</span>
                        </div>
                    </div>
                    
                    @if($rdv->motif)
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1"><i class="fas fa-notes-medical text-blue-600 mr-1"></i> Motif</p>
                        <p class="text-sm text-gray-700">{{ $rdv->motif }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $rendezvous->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-3xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 text-lg">Aucun rendez-vous à venir</p>
                <p class="text-gray-400 text-sm mt-1">Vous n'avez pas de consultations programmées</p>
                <a href="{{ route('patient.rendez-vous.create') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">
                    <i class="fas fa-plus mr-2"></i> Prendre un rendez-vous
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Annuler le rendez-vous',
            text: "Êtes-vous sûr de vouloir annuler ce rendez-vous ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E53935',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endsection