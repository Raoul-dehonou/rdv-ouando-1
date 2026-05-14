@extends('layouts.app')

@section('header_icon', 'fa-calendar-plus')
@section('header_title', 'Nouveau rendez-vous')
@section('header_subtitle', 'Créer un rendez-vous')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Nouveau rendez-vous</h2>
                    <p class="text-sm text-gray-500">Remplissez les informations ci-dessous</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                        <i class="fas fa-calendar-alt mr-1"></i> Planification
                    </span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.rendez-vous.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-users text-blue-600"></i>
                    Participants
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Patient <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="patient_id" required 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="">-- Choisir un patient --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->user->name }} ({{ $patient->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Médecin <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user-md absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="medecin_id" required 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="">-- Choisir un médecin --</option>
                                @foreach($medecins as $medecin)
                                    <option value="{{ $medecin->id }}" {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                                        Dr. {{ $medecin->user->name }} ({{ $medecin->specialite ?? 'Généraliste' }})
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('medecin_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                    Date et heure
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="date" name="date" value="{{ old('date') }}" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Heure <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="time" name="heure" value="{{ old('heure') }}" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        @error('heure') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    Informations complémentaires
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
                        <div class="relative">
                            <i class="fas fa-file-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="motif" value="{{ old('motif') }}" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Consultation, contrôle, urgence...">
                        </div>
                        @error('motif') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <div class="relative">
                            <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="statut" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirme" {{ old('statut') == 'confirme' ? 'selected' : '' }}>Confirmé</option>
                                <option value="annule" {{ old('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                                <option value="termine" {{ old('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('statut') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <div class="relative">
                    <i class="fas fa-sticky-note absolute left-3 top-5 text-gray-400"></i>
                    <textarea name="notes" rows="4" 
                              class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                              placeholder="Informations complémentaires...">{{ old('notes') }}</textarea>
                </div>
                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    <p class="text-sm text-blue-800">Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires</p>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.rendez-vous.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Créer le rendez-vous
                </button>
            </div>
        </form>
    </div>
</div>
@endsection