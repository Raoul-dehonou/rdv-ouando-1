@extends('layouts.app')

@section('header_icon', 'fa-envelope')
@section('header_title', 'Messages contact')
@section('header_subtitle', 'Gestion des demandes')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Messages contact</h1>
                <p class="text-sm text-gray-500">Gérez les messages envoyés</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
                <i class="fas fa-envelope mr-2"></i> Total : {{ $contacts->total() }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Total messages</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-envelope text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $contacts->total() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-amber-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Non lus</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-envelope-open-text text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-orange-600">{{ $nonLus }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-rose-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Non traités</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-red-600">{{ $nonTraites }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Sujet</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $contact)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300 {{ !$contact->lu ? 'bg-blue-50' : '' }}">
                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $contact->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($contact->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $contact->nom }}</p>
                                    @if($contact->telephone)
                                        <p class="text-xs text-gray-500"><i class="fas fa-phone-alt mr-1"></i>{{ $contact->telephone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $contact->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">{{ $contact->sujet }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if(!$contact->lu)
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Non lu</span>
                                @endif
                                @if(!$contact->traite)
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Non traité</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Traité</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($contact->date_envoi)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="w-8 h-8 flex items-center justify-center text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="delete-form inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn w-8 h-8 flex items-center justify-center text-red-600 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition" title="Supprimer" data-name="{{ $contact->nom }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-envelope text-4xl text-blue-600"></i>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">Aucun message reçu</p>
                                <p class="text-gray-400 text-sm mt-1">Les messages du formulaire de contact apparaîtront ici</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            const name = this.dataset.name;
            Swal.fire({
                title: 'Confirmation',
                text: `Supprimer le message de "${name}" ?`,
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