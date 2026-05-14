@extends('layouts.app')

@section('header_icon', 'fa-calendar-week')
@section('header_title', 'Mon agenda')
@section('header_subtitle', 'Visualisez vos rendez-vous et disponibilités')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-800">Agenda de la semaine</p>
                <p class="text-sm text-gray-500">Du {{ now()->startOfWeek()->format('d/m/Y') }} au {{ now()->endOfWeek()->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Heure</th>
                        @foreach($weekDays as $day)
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                {{ $day->translatedFormat('l d/m') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($hours as $heure)
                        @php
                            $heureAffichee = str_pad($heure, 2, '0', STR_PAD_LEFT) . ':00';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">{{ $heureAffichee }}</td>
                            @foreach($weekDays as $day)
                                @php
                                    $dateKey = $day->format('Y-m-d');
                                    $slotKey = $dateKey . '|' . $heureAffichee;
                                    $rdv = $appointmentsBySlot[$slotKey] ?? null;
                                    $estDisponible = isset($dispoSlots[$slotKey]);
                                @endphp
                                <td class="px-4 py-3 text-sm">
                                    @if($rdv)
                                        {{-- Réservé --}}
                                        <div class="bg-red-50 p-2 rounded-lg border-l-4 border-red-500">
                                            <div class="font-medium text-gray-800">{{ $rdv->patient->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $rdv->motif ?? 'Consultation' }}</div>
                                            <a href="{{ route('medecin.rendez-vous.show', $rdv) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                                <i class="fas fa-eye"></i> Détails
                                            </a>
                                        </div>
                                    @elseif($estDisponible)
                                        {{-- Créneau libre (disponibilité) --}}
                                        <div class="bg-green-50 p-2 rounded-lg border-l-4 border-green-500 text-center">
                                            <span class="text-green-700 text-sm">✓ Libre</span>
                                        </div>
                                    @else
                                        {{-- Hors disponibilité --}}
                                        <div class="bg-gray-50 p-2 rounded-lg text-center">
                                            <span class="text-gray-400 text-sm">Fermé</span>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection