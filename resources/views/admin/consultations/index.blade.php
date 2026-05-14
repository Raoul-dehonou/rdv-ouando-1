@extends('layouts.app')

@section('header_icon', 'fa-notes-medical')
@section('header_title', 'Gestion des consultations')
@section('header_subtitle', 'Historique et suivi')

@section('content')
<div class="space-y-6">
    
    <!-- En-tête -->
    <div class="mt-8">
        <div></div>
        <a href="{{ route('admin.consultations.create') }}" 
           style="background: linear-gradient(135deg, #1761e0 0%, #134db3 100%);"
           class="text-white px-4 py-2 rounded-lg transition flex items-center gap-2 shadow-md hover:shadow-lg">
            <i class="fas fa-plus"></i> Nouvelle consultation
        </a>
    </div>
    
    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <input type="date" id="filterDate" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1761e0]">
            <select id="filterMedecin" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1761e0]">
                <option value="">Tous les médecins</option>
                @foreach($medecins as $medecin)
                    <option value="{{ $medecin->id }}">{{ $medecin->user->name ?? 'Dr. ' . $medecin->id }} - {{ $medecin->specialite ?? 'Généraliste' }}</option>
                @endforeach
            </select>
            <button id="resetFilters" class="border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50 transition">
                <i class="fas fa-undo-alt"></i> Réinitialiser
            </button>
        </div>
    </div>
    
    <!-- Tableau des consultations -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Médecin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Diagnostic</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $consultation)
                    <tr class="hover:bg-gray-50 transition consultation-row" 
                        data-date="{{ $consultation->date_consultation }}" 
                        data-medecin="{{ $consultation->medecin_id }}">
                        <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#1761e0] to-[#134db3] flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr($consultation->patient->user->name ?? 'N/A', 0, 1) }}
                                </div>
                                <span class="font-medium">{{ $consultation->patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $consultation->medecin->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $consultation->medecin->specialite ?? 'Généraliste' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ Str::limit($consultation->diagnostic ?? '-', 60) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.consultations.show', $consultation->id) }}" 
                               class="text-[#1761e0] hover:text-[#134db3] transition flex items-center gap-1 text-sm">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-notes-medical text-4xl mb-2 text-gray-300"></i>
                            <p>Aucune consultation trouvée</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $consultations->links() }}
    </div>
</div>

<script>
    const filterDate = document.getElementById('filterDate');
    const filterMedecin = document.getElementById('filterMedecin');
    const resetBtn = document.getElementById('resetFilters');
    const rows = document.querySelectorAll('.consultation-row');
    
    function filterTable() {
        const dateValue = filterDate.value;
        const medecinValue = filterMedecin.value;
        
        rows.forEach(row => {
            let show = true;
            if (dateValue && row.getAttribute('data-date') !== dateValue) show = false;
            if (medecinValue && row.getAttribute('data-medecin') !== medecinValue) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    
    if (filterDate) filterDate.addEventListener('change', filterTable);
    if (filterMedecin) filterMedecin.addEventListener('change', filterTable);
    
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (filterDate) filterDate.value = '';
            if (filterMedecin) filterMedecin.value = '';
            rows.forEach(row => row.style.display = '');
        });
    }
</script>
@endsection