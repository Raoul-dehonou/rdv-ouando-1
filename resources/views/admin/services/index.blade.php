@extends('layouts.app')

@section('header_icon', 'fa-stethoscope')
@section('header_title', 'Gestion des services')
@section('header_subtitle', 'Liste et gestion des services médicaux')

@section('content')
<div class="space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Services</h1>
                <p class="text-sm text-gray-500">Liste des services médicaux</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
                <i class="fas fa-list mr-2"></i> Total : {{ $services->total() }}
            </div>
            <a href="{{ route('admin.services.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium flex items-center gap-2 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Nouveau service</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Total services</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-stethoscope text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $services->total() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Services actifs</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $services->where('actif', true)->count() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-500/10 to-gray-600/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Services inactifs</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-ban text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $services->where('actif', false)->count() }}</p>
            </div>
        </div>
        <div class="group relative bg-white rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500 font-medium">Catégories</p>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-tags text-white text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $services->pluck('categorie')->unique()->filter()->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($services as $service)
                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $service->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    <i class="fas fa-stethoscope text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $service->nom }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                            {{ Str::limit($service->description, 60) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($service->categorie)
                                <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">{{ $service->categorie }}</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">Non catégorisé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($service->actif)
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Actif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="w-8 h-8 flex items-center justify-center text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="delete-btn w-8 h-8 flex items-center justify-center text-red-600 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition" data-name="{{ $service->nom }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">Aucun service trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $services->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Confirmation',
                text: `Supprimer le service "${this.dataset.name}" ?`,
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