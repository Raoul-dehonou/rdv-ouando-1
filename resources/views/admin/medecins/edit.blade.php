@extends('layouts.app')

@section('header_icon', 'fa-user-edit')
@section('header_title', 'Modifier un médecin')
@section('header_subtitle', 'Modification des informations du médecin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <!-- Formulaire principal -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- En-tête -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class= "mt-8">
                    <h2 class="text-xl font-bold text-gray-800">Modification</h2>
                    <p class="text-sm text-gray-500">Modifiez les informations ci-dessous</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                        <i class="fas fa-stethoscope mr-1"></i> Médecin - ID: {{ $medecin->id }}
                    </span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.medecins.update', $medecin) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Identifiants de connexion -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-key text-blue-600"></i>
                    Identifiants de connexion
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="name" value="{{ old('name', $medecin->user->name) }}" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-400 bg-red-50 @enderror"
                                   placeholder="Dr. Jean Dupont">
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email professionnel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" value="{{ old('email', $medecin->user->email) }}" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                                   placeholder="prenom.nom@hopital.com">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nouveau mot de passe <span class="text-gray-400 text-xs">(laisser vide pour ne pas changer)</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password" 
                                   class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-400 bg-red-50 @enderror"
                                   placeholder="••••••••">
                            <button type="button" class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmer le nouveau mot de passe
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password_confirmation" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations professionnelles -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-briefcase-medical text-blue-600"></i>
                    Informations professionnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité</label>
                        <div class="relative">
                            <i class="fas fa-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="specialite" value="{{ old('specialite', $medecin->specialite) }}" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('specialite') border-red-400 bg-red-50 @enderror"
                                   placeholder="Cardiologie, Pédiatrie, ...">
                        </div>
                        @error('specialite') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <div class="relative">
                            <i class="fas fa-toggle-on absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="is_active" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="1" {{ $medecin->is_active ? 'selected' : '' }}>🟢 Actif - Disponible</option>
                                <option value="0" {{ !$medecin->is_active ? 'selected' : '' }}>🔴 Inactif - Indisponible</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Affichage des dates (info seulement) -->
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-calendar-plus text-gray-400"></i>
                                <span class="text-gray-500">Créé le :</span>
                                <span class="text-gray-700 font-medium">{{ $medecin->created_at ? $medecin->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-calendar-edit text-gray-400"></i>
                                <span class="text-gray-500">Dernière modification :</span>
                                <span class="text-gray-700 font-medium">{{ $medecin->updated_at ? $medecin->updated_at->format('d/m/Y H:i') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Note d'information -->
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p><span class="font-medium">Note :</span> Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires.</p>
                        <p class="text-xs mt-1">Le mot de passe ne sera modifié que si vous renseignez un nouveau mot de passe et sa confirmation.</p>
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.medecins.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>
@endpush

@endsection