@extends('layouts.app')

@section('header_icon', 'fa-user-plus')
@section('header_title', 'Ajouter un patient')
@section('header_subtitle', 'Enregistrement d\'un nouveau patient')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <!-- Formulaire principal -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- En-tête -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="mt-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Nouveau patient</h2>
                    <p class="text-sm text-gray-500">Remplissez les informations ci-dessous</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.patients.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Informations personnelles -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-600"></i>
                    Informations personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="name" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Jean Kouassi">
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="exemple@email.com">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmer le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="date" name="date_naissance" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        @error('date_naissance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                        <div class="relative">
                            <i class="fas fa-briefcase absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="profession" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Enseignant, Commerçant...">
                        </div>
                        @error('profession') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <!-- Coordonnées -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-address-card text-blue-600"></i>
                    Coordonnées
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="tel" name="telephone" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="+229 XX XX XX XX">
                        </div>
                        @error('telephone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact urgence</label>
                        <div class="relative">
                            <i class="fas fa-ambulance absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="tel" name="contact_urgence" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="+229 XX XX XX XX">
                        </div>
                        @error('contact_urgence') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                            <textarea name="adresse" rows="2" 
                                      class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                      placeholder="Adresse complète"></textarea>
                        </div>
                        @error('adresse') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Numéro sécurité sociale</label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="num_secu_sociale" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="2 85 06 15 512 345 67">
                        </div>
                        @error('num_secu_sociale') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <!-- Note d'information -->
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    <p class="text-sm text-blue-800">Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires</p>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.patients.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Enregistrer le patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection