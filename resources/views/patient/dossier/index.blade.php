@extends('layouts.app')

@section('header_icon', 'fa-folder-open')
@section('header_title', 'Mon dossier médical')
@section('header_subtitle', 'Historique de vos consultations')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-folder-open text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Mon dossier médical</h1>
                <p class="text-sm text-gray-500">Toutes vos consultations</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médecin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnostic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $consultation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">{{ $consultation->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            Dr. {{ $consultation->rendezvous->medecin->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($consultation->diagnostic, 50) ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('patient.dossier.consultation.show', $consultation) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-gray-500">Aucune consultation trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $consultations->links() }}
        </div>
    </div>
</div>
@endsection