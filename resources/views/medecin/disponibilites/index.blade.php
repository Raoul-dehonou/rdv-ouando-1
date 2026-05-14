@extends('layouts.app')

@section('header_icon', 'fa-clock')
@section('header_title', 'Mes disponibilités')
@section('header_subtitle', 'Gérez vos créneaux de consultation')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-700">Gérez vos créneaux de consultation</p>
            </div>
        </div>
        <button onclick="document.getElementById('addForm').classList.toggle('hidden')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
            <i class="fas fa-plus mr-1"></i> Ajouter
        </button>
    </div>

    <!-- Formulaire d'ajout -->
    <div id="addForm" class="hidden bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800"><i class="fas fa-plus-circle text-blue-600 mr-2"></i>Nouvelle disponibilité</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('medecin.disponibilites.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jour <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure début <span class="text-red-500">*</span></label>
                        <input type="time" name="heure_debut" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure fin <span class="text-red-500">*</span></label>
                        <input type="time" name="heure_fin" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                </div>
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('addForm').classList.add('hidden')" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">Annuler</button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des disponibilités -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800"><i class="fas fa-list text-blue-600 mr-2"></i>Mes créneaux</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Heure début</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Heure fin</th>
                        
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($disponibilites as $dispo)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">{{ $dispo->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $dispo->heure_debut }}</td>
                        <td class="px-6 py-4 text-sm">{{ $dispo->heure_fin }}</td>
                        
                        <td class="px-6 py-4">
                            <form action="{{ route('medecin.disponibilites.destroy', $dispo) }}" method="POST" class="delete-form inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-btn text-red-600 hover:text-red-800 transition">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-clock text-3xl mb-2 opacity-50"></i>
                            <p>Aucune disponibilité enregistrée</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Confirmation',
                text: 'Supprimer ce créneau ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) this.closest('form').submit();
            });
        });
    });
</script>
@endsection