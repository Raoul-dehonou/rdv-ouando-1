@extends('layouts.app')

@section('header_icon', 'fa-home')
@section('header_title', 'Mon espace patient')
@section('header_subtitle', 'Bienvenue, ' . Auth::user()->name)

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100 mt-8">
        <div class="flex items-center space-x-4 mt-8">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-home text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Vue d'ensemble</h1>
            </div>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium border border-blue-200">
            <i class="far fa-calendar-alt mr-2"></i> {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="relative bg-blue-600 rounded-2xl p-6 hover:shadow-xl transition border border-blue-500">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-blue-100 font-medium">Prochain rendez-vous</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-day text-white text-lg"></i>
                    </div>
                </div>
                @if(isset($nextAppointment) && $nextAppointment)
                    <p class="text-lg font-semibold text-white">{{ $nextAppointment->date->translatedFormat('d F Y') }} à {{ $nextAppointment->heure }}</p>
                    <p class="text-sm text-blue-100 mt-1">Dr {{ $nextAppointment->medecin->user->name }}</p>
                @else
                    <p class="text-blue-100">Aucun rendez-vous à venir</p>
                    <a href="{{ route('patient.rendez-vous.create') }}" class="text-sm text-white underline">Prendre rendez-vous</a>
                @endif
            </div>
        </div>

        <div class="relative bg-green-600 rounded-2xl p-6 hover:shadow-xl transition border border-green-500">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-green-100 font-medium">Consultations passées</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ $pastConsultationsCount ?? 0 }}</p>
            </div>
        </div>

        <div class="relative bg-red-500 rounded-2xl p-6 hover:shadow-xl transition border border-yellow-400">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-red-100 font-medium">Notifications</p>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ $unreadNotificationsCount ?? 0 }}</p>
                <p class="text-sm text-yellow-100">non lues</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-600 mr-2"></i>
                Dernière consultation
            </h2>
        </div>
        <div class="p-6">
            @if(isset($lastConsultation) && $lastConsultation)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><span class="text-gray-500">Date :</span> <span class="text-gray-800">{{ $lastConsultation->created_at->translatedFormat('d F Y') }}</span></div>
                    <div><span class="text-gray-500">Médecin :</span> <span class="text-gray-800">Dr {{ $lastConsultation->rendezvous->medecin->user->name }}</span></div>
                    <div class="md:col-span-2"><span class="text-gray-500">Diagnostic :</span> <span class="text-gray-800">{{ Str::limit($lastConsultation->diagnostic, 100) }}</span></div>
                </div>
                <div class="mt-4">
                    <!-- ✅ ROUTE CORRIGÉE : 'patient.dossier.consultation.show' au lieu de 'patient.dossier.show' -->
                    <a href="{{ route('patient.dossier.consultation.show', $lastConsultation) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                        Voir les détails <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucune consultation enregistrée pour le moment.</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('patient.rendez-vous.create') }}" class="group bg-blue-600 rounded-2xl p-6 hover:bg-blue-700 transition flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-white">Prendre rendez-vous</h3>
                <p class="text-sm text-blue-100">Consultez un médecin rapidement</p>
            </div>
            <i class="fas fa-arrow-right text-white group-hover:translate-x-1 transition-transform"></i>
        </a>
        <a href="{{ route('patient.documents.index') }}" class="group bg-green-600 rounded-2xl p-6 hover:bg-green-700 transition flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-white">Mes documents</h3>
                <p class="text-sm text-green-100">Ordonnances, résultats, comptes-rendus</p>
            </div>
            <i class="fas fa-arrow-right text-white group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>
@endsection