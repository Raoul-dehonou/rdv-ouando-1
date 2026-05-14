@extends('layouts.app')

@section('header_icon', 'fa-envelope')
@section('header_title', 'Messagerie')
@section('header_subtitle', 'Conversation avec ' . ($contact->name ?? 'Patient'))

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Conversation</h1>
                <p class="text-sm text-gray-500">Avec {{ $contact->name ?? 'Patient' }}</p>
            </div>
        </div>
        <a href="{{ url('/medecin/messagerie') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Zone des messages -->
        <div class="h-96 overflow-y-auto p-6 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }} rounded-2xl px-4 py-2 shadow">
                        <p class="text-sm break-words">{{ $message->content }}</p>
                        <p class="text-xs mt-1 opacity-70">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Aucun message. Commencez la conversation !</p>
            @endforelse
        </div>

        <!-- Formulaire d'envoi -->
        <div class="border-t border-gray-100 p-4 bg-gray-50">
            <form action="{{ route('medecin.messagerie.send', $contact) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="message" placeholder="Écrivez votre message..." required class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-paper-plane"></i> Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('messages-container');
    if (container) container.scrollTop = container.scrollHeight;
</script>
@endsection