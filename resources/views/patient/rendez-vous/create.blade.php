@extends('layouts.app')

@section('header_icon', 'fa-calendar-plus')
@section('header_title', 'Prendre rendez-vous')
@section('header_subtitle', 'Remplissez le formulaire ci-dessous')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4 mt-8">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-plus text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Remplissez le formulaire ci-dessous</h1>
            </div>
        </div>
        <a href="{{ route('patient.rendez-vous.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Veuillez corriger les erreurs suivantes :</strong>
            </div>
            <ul class="mt-2 ml-6 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-stethoscope text-blue-600"></i>
                Informations du rendez-vous
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('patient.rendez-vous.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Médecin <span class="text-red-500">*</span>
                        </label>
                        <select name="medecin_id" id="medecin_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Choisir un médecin --</option>
                            @foreach($medecins as $medecin)
                            <option value="{{ $medecin->id }}" {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                                Dr. {{ $medecin->user->name }} - {{ $medecin->specialite ?? 'Médecine générale' }}
                            </option>
                            @endforeach
                        </select>
                        @error('medecin_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" id="date" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" value="{{ old('date') }}" min="{{ date('Y-m-d') }}">
                        @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Heure <span class="text-red-500">*</span>
                        </label>
                        <select name="heure" id="heure" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Sélectionnez médecin et date d'abord --</option>
                        </select>
                        @error('heure') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Motif de la consultation
                        </label>
                        <textarea name="motif" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Décrivez brièvement le motif...">{{ old('motif') }}</textarea>
                        @error('motif') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100 mt-6">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p>Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires.</p>
                            <p class="text-xs mt-1">Une fois votre rendez-vous confirmé, vous recevrez une notification par email.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('patient.rendez-vous.index') }}" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-calendar-check mr-1"></i> Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const medecinSelect = document.getElementById('medecin_id');
    const dateInput = document.getElementById('date');
    const heureSelect = document.getElementById('heure');

    function loadCreneaux() {
        const medecinId = medecinSelect.value;
        const date = dateInput.value;

        if (medecinId && date) {
            heureSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/patient/creneaux?medecin_id=${medecinId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    heureSelect.innerHTML = '<option value="">-- Choisir un créneau --</option>';
                    if (data.length > 0) {
                        data.forEach(creneau => {
                            const option = document.createElement('option');
                            option.value = creneau.heure;
                            option.textContent = `${creneau.heure}`;
                            heureSelect.appendChild(option);
                        });
                    } else {
                        heureSelect.innerHTML = '<option value="">Aucun créneau disponible</option>';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    heureSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            heureSelect.innerHTML = '<option value="">-- Sélectionnez médecin et date --</option>';
        }
    }

    medecinSelect.addEventListener('change', loadCreneaux);
    dateInput.addEventListener('change', loadCreneaux);
</script>
@endsection