@extends('layouts.app')

@section('header_icon', 'fa-user-circle')
@section('header_title', 'Mon profil')
@section('header_subtitle', 'Gérez vos informations personnelles')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <!-- Informations personnelles -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                Mes informations
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Changer le mot de passe -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-lock text-blue-600 mr-2"></i>
                Changer mon mot de passe
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe actuel <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-key"></i> Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Supprimer le compte -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-red-100">
        <div class="px-6 py-4 border-b border-red-100 bg-gradient-to-r from-red-50 to-white">
            <h2 class="font-semibold text-red-600 flex items-center">
                <i class="fas fa-trash-alt text-red-600 mr-2"></i>
                Supprimer mon compte
            </h2>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Cette action est irréversible. Toutes vos données seront définitivement supprimées.</p>
            <form action="{{ route('profile.destroy') }}" method="POST" id="deleteAccountForm">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmez avec votre mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="button" id="deleteAccountBtn" class="px-6 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Supprimer mon compte
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('deleteAccountBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette suppression est irréversible. Toutes vos données seront perdues.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22C55E',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Oui, supprimer mon compte',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAccountForm').submit();
            }
        });
    });
</script>
@endsection