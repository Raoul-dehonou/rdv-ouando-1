@extends('layouts.app')

@section('header_icon', 'fa-notes-medical')
@section('header_title', 'Ajouter une consultation')
@section('header_subtitle', 'Renseignez les informations médicales pour le patient')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4 mt-8">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-notes-medical text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Nouvelle consultation</h1>
                <p class="text-sm text-gray-500">Pour le rendez-vous du {{ $rendezvous->date->format('d/m/Y') }} à {{ $rendezvous->heure }}</p>
            </div>
        </div>
        <a href="{{ route('medecin.rendez-vous.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-stethoscope text-blue-600"></i>
                Formulaire de consultation
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('medecin.consultations.store', $rendezvous) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diagnostic <span class="text-red-500">*</span></label>
                        <textarea name="diagnostic" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" required placeholder="Décrivez le diagnostic..."></textarea>
                        @error('diagnostic') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prescription (traitement)</label>
                        <textarea name="prescription" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Indiquez les médicaments ou traitements prescrits..."></textarea>
                        @error('prescription') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes complémentaires</label>
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Ajoutez des informations supplémentaires..."></textarea>
                        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prochain rendez-vous suggéré (optionnel)</label>
                        <input type="date" name="prochain_rdv" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        @error('prochain_rdv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                    <a href="{{ route('medecin.rendez-vous.index') }}" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">Annuler</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-save mr-1"></i> Enregistrer la consultation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection