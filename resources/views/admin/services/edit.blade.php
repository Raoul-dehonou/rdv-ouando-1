@extends('layouts.app')

@section('title', 'Modifier un service')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
        <h2 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-stethoscope text-purple-600 mr-2"></i>
            Modifier le service
        </h2>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom du service</label>
                    <input type="text" name="nom" value="{{ old('nom', $service->nom) }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-purple-500 focus:border-purple-500">
                    @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-purple-500 focus:border-purple-500">{{ old('description', $service->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="actif" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-purple-500 focus:border-purple-500">
                        <option value="1" {{ $service->actif ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ !$service->actif ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.services.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Annuler</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
