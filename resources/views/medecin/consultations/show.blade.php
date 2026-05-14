@extends('layouts.app')

@section('header_icon', 'fa-file-alt')
@section('header_title', 'Détails consultation')
@section('header_subtitle', 'Consultation du ' . $consultation->created_at->format('d/m/Y'))

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-file-alt text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-700">Détails de la consultation</h1>
                <p class="text-sm text-gray-500">du {{ $consultation->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('medecin.consultations.edit', $consultation) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-stethoscope text-blue-600"></i>
                Informations médicales
            </h2>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Patient</label>
                <p class="font-semibold text-gray-800">{{ $consultation->patient->user->name }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Diagnostic</label>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $consultation->diagnostic }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Prescription</label>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $consultation->prescription ?? 'Aucune' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Notes</label>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $consultation->notes ?? 'Aucune' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Prochain rendez-vous suggéré</label>
                <p class="text-gray-800">{{ $consultation->prochain_rdv ? $consultation->prochain_rdv->format('d/m/Y') : 'Non défini' }}</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            @if($consultation->patient)
               
            @endif
        </div>
    </div>
</div>
@endsection