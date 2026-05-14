@extends('layouts.app')

@section('header_icon', 'fa-users')
@section('header_title', 'Gestion des patients')
@section('header_subtitle', 'Liste et suivi des patients')
@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Patients</h1>
                <p class="text-sm text-gray-500">Liste et gestion des patients</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border  border-blue-200">
                <i class="fas fa-users mr-2"></i> Total : {{ $patients->total() }}
            </div>
            <a href="{{ route('admin.patients.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium flex items-center gap-2 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Ajouter</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Total patients</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $patients->total() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Consultations</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-stethoscope text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $patients->sum(function($p) { return $p->consultations->count(); }) }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Rendez-vous à venir</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $patients->sum(function($p) { return $p->rendezVous->where('date', '>=', now())->count(); }) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date naissance</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patients as $patient)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                                </div>
                                <p class="font-semibold text-gray-800">{{ $patient->user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="font-mono text-sm">{{ $patient->user->email }}</span></td>
                        <td class="px-6 py-4">{{ $patient->telephone ?? '-' }}</td>
                       <td class="px-6 py-4">{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') : '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.patients.edit', $patient) }}" class="w-8 h-8 flex items-center justify-center text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="delete-btn w-8 h-8 flex items-center justify-center text-red-600 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition" data-name="{{ $patient->user->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-16">Aucun patient</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $patients->links() }}
    </div>
</div>
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Confirmation',
                text: `Supprimer ${this.dataset.name} ?`,
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