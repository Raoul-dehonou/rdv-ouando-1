@extends('layouts.app')

@section('title', 'Message de ' . $contact->nom)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-2 text-[#1a6fff] hover:text-[#0d5ae0] transition">
            <i class="fas fa-arrow-left"></i>
            <span>Retour à la liste</span>
        </a>
        <div class="flex gap-2">
            @if(!$contact->traite)
            <form action="{{ route('admin.contacts.traite', $contact) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-check-circle mr-1"></i> Marquer comme traité
                </button>
            </form>
            @else
            <form action="{{ route('admin.contacts.non-traite', $contact) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-undo mr-1"></i> Marquer comme non traité
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-user mr-1"></i> Nom complet</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $contact->nom }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-envelope mr-1"></i> Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $contact->email }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-phone mr-1"></i> Téléphone</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $contact->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-tag mr-1"></i> Sujet</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $contact->sujet }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-calendar mr-1"></i> Date d'envoi</p>
                    <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($contact->date_envoi)->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1"><i class="fas fa-info-circle mr-1"></i> Statut</p>
                    <div class="flex gap-2 mt-1">
                        @if($contact->lu)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Lu</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded-full">Non lu</span>
                        @endif
                        @if($contact->traite)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Traité</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Non traité</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-500 mb-2"><i class="fas fa-comment mr-1"></i> Message</p>
                <div class="bg-gray-50 rounded-xl p-5">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6">
        <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-reply-all text-[#1a6fff] mr-2"></i>Répondre</h3>
        <p class="text-gray-600 text-sm mb-3">Vous pouvez répondre à ce message en utilisant l'adresse email suivante :</p>
        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->sujet }}" class="inline-flex items-center gap-2 bg-[#1a6fff] text-white px-5 py-2.5 rounded-xl hover:bg-[#0d5ae0] transition">
            <i class="fas fa-envelope"></i>
            <span>Répondre par email</span>
        </a>
    </div>
</div>
@endsection
