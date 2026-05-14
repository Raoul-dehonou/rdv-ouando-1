@extends('layouts.app')

@section('header_icon', 'fa-notes-medical')
@section('header_title', 'Mes consultations')
@section('header_subtitle', 'Historique de vos consultations')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-notes-medical text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Mes consultations</h1>
                <p class="text-sm text-gray-500">Historique de vos consultations</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
            <i class="fas fa-chart-line mr-2"></i> Total : {{ $consultations->total() }}
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Diagnostic</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($consultations as $consultation)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $consultation->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($consultation->patient->user->name, 0, 1)) }}
                                </div>
                                <p class="font-semibold text-gray-800">{{ $consultation->patient->user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($consultation->diagnostic, 60) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('medecin.consultations.show', $consultation) }}" class="w-8 h-8 flex items-center justify-center text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-notes-medical text-4xl text-blue-600"></i>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">Aucune consultation</p>
                                <p class="text-gray-400 text-sm mt-1">Les consultations que vous avez effectuées apparaîtront ici</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($consultations->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            {{ $consultations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection