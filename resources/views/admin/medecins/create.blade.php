@extends('layouts.app')

@section('header_icon', 'fa-user-md')
@section('header_title', 'Ajouter un médecin')
@section('header_subtitle', 'Enregistrement d\'un nouveau médecin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Nouveau médecin</h2>
                    <p class="text-sm text-gray-500">Remplissez les informations ci-dessous</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                        <i class="fas fa-stethoscope mr-1"></i> Corps médical
                    </span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.medecins.store') }}" method="POST" class="p-6">
            @csrf
            
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
                            <input type="text" name="name" value="{{ old('name') }}" required 
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
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                                   placeholder="prenom.nom@hopital.com">
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
                            Confirmer le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <i class="fas fa-briefcase-medical text-blue-600"></i>
                    Informations professionnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="specialite" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="">-- Sélectionner une spécialité --</option>
                                <option value="Cardiologie" {{ old('specialite') == 'Cardiologie' ? 'selected' : '' }}>Cardiologie</option>
                                <option value="Pédiatrie" {{ old('specialite') == 'Pédiatrie' ? 'selected' : '' }}>Pédiatrie</option>
                                <option value="Gynécologie" {{ old('specialite') == 'Gynécologie' ? 'selected' : '' }}>Gynécologie</option>
                                <option value="Autre" {{ old('specialite') == 'Autre' ? 'selected' : '' }}>Autre (à préciser)</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('specialite') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div id="autre_specialite_container" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Précisez la spécialité</label>
                        <div class="relative">
                            <i class="fas fa-pen absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="autre_specialite" value="{{ old('autre_specialite') }}" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Ex: Neurologie, Dermatologie...">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <div class="relative">
                            <select name="is_active" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white cursor-pointer">
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    <p class="text-sm text-blue-800">Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires</p>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.medecins.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const specialiteSelect = document.querySelector('select[name="specialite"]');
    const autreContainer = document.getElementById('autre_specialite_container');
    const autreInput = document.querySelector('input[name="autre_specialite"]');

    function toggleAutreSpecialite() {
        if (specialiteSelect.value === 'Autre') {
            autreContainer.style.display = 'block';
            autreInput.required = true;
        } else {
            autreContainer.style.display = 'none';
            autreInput.required = false;
            autreInput.value = '';
        }
    }

    specialiteSelect.addEventListener('change', toggleAutreSpecialite);
    toggleAutreSpecialite();

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
@endsection