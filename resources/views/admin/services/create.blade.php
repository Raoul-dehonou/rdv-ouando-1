@extends('layouts.app')

@section('header_icon', 'fa-stethoscope')
@section('header_title', 'Services')
@section('header_subtitle', 'Insertion de service')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 ">
    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
        <h2 class="font-semibold text-gray-800 flex items-center mt-8">
            <i class="fas fa-stethoscope text-[#1a6fff] mr-2"></i>
            Ajouter un service
        </h2>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom du service</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#1a6fff] focus:border-[#1a6fff]">
                    @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#1a6fff] focus:border-[#1a6fff]">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <input type="text" name="categorie" value="{{ old('categorie') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#1a6fff] focus:border-[#1a6fff]"
                           placeholder="Ex: Consultations, Urgences, Analyses...">
                    @error('categorie') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="actif" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#1a6fff] focus:border-[#1a6fff]">
                        <option value="1">Actif</option>
                        <option value="0">Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.services.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Annuler</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white rounded-lg hover:shadow-lg transition">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
