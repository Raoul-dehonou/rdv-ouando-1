@extends('layouts.app')

@section('header_icon', 'fa-edit')
@section('header_title', 'Modifier consultation')
@section('header_subtitle', 'Modification des informations de la consultation')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl shadow-lg flex items-center justify-center">
                <i class="fas fa-edit text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-700">Modifiez les informations ci-dessous</h1>
            </div>
        </div>
        <a href="{{ route('medecin.consultations.show', $consultation) }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
            <i class="fas fa-times mr-1"></i> Annuler
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-stethoscope text-blue-600"></i>
                Informations médicales
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('medecin.consultations.update', $consultation) }}" method="POST">
                @csrf 
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diagnostic <span class="text-red-500">*</span></label>
                        <textarea name="diagnostic" rows="3" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('diagnostic', $consultation->diagnostic) }}</textarea>
                        @error('diagnostic') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prescription</label>
                        <textarea name="prescription" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('prescription', $consultation->prescription) }}</textarea>
                        @error('prescription') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $consultation->notes) }}</textarea>
                        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prochain rendez-vous</label>
                        <input type="date" name="prochain_rdv" value="{{ old('prochain_rdv', $consultation->prochain_rdv ? $consultation->prochain_rdv->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        @error('prochain_rdv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                    <a href="{{ route('medecin.consultations.show', $consultation) }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-save mr-1"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection