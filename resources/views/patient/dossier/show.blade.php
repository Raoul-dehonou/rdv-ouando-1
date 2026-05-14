@extends('layouts.app')

@section('header_icon', 'fa-file-alt')
@section('header_title', 'Détails consultation')
@section('header_subtitle', 'Consultation du ' . $consultation->created_at->format('d/m/Y'))

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-file-alt text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Fiche médicale</h1>
                <p class="text-sm text-gray-500">Consultation du {{ $consultation->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('patient.dossier.consultation.pdf', $consultation->id) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Télécharger PDF
            </a>
            <a href="{{ route('patient.dossier.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left mr-1"></i> Retour
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
                <label class="text-sm text-gray-500 block mb-1">Médecin</label>
                <p class="font-semibold text-gray-800">Dr. {{ $consultation->rendezvous->medecin->user->name ?? 'N/A' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Spécialité</label>
                <p class="text-gray-800">{{ $consultation->rendezvous->medecin->specialite ?? 'Médecine générale' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Date de consultation</label>
                <p class="text-gray-800">{{ $consultation->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Diagnostic</label>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $consultation->diagnostic ?? 'Aucun diagnostic renseigné' }}</p>
                </div>
            </div>
            @if($consultation->prescription)
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Prescription</label>
                <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $consultation->prescription }}</p>
                </div>
            </div>
            @endif
            @if($consultation->notes)
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Notes complémentaires</label>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 italic">
                    <p class="text-gray-600">{{ $consultation->notes }}</p>
                </div>
            </div>
            @endif
            @if($consultation->prochain_rdv)
            <div class="mb-6">
                <label class="text-sm text-gray-500 block mb-1">Prochain rendez-vous suggéré</label>
                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($consultation->prochain_rdv)->format('d/m/Y') }}</p>
                </div>
            </div>
            @endif
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            <a href="{{ route('patient.dossier.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Toutes mes consultations
            </a>
        </div>
    </div>
</div>
@endsection