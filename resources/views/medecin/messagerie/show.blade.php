@extends('layouts.app')

@section('header_icon', 'fa-envelope')
@section('header_title', 'Messagerie')
@section('header_subtitle', 'Conversation avec ' . ($contact->name ?? 'Patient'))

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Conversation</h1>
                <p class="text-sm text-gray-500">Avec {{ $contact->name ?? 'Patient' }}</p>
            </div>
        </div>
        <a href="{{ url('/medecin/messagerie') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="h-96 overflow-y-auto p-6 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md {{ $message->sender_id == auth()->id() ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : 'bg-white text-gray-800 border border-gray-200' }} rounded-2xl px-4 py-2 shadow">
                        @if($message->image)
                            <img src="{{ asset('storage/' . $message->image) }}" class="max-w-full rounded-lg mb-2">
                        @endif
                        <p class="text-sm break-words">{{ $message->message ?? $message->content ?? '' }}</p>
                        <p class="text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Aucun message. Commencez la conversation !</p>
            @endforelse
        </div>

        <div class="border-t border-gray-100 p-4 bg-white">
            <form action="{{ route('medecin.messagerie.send', $contact) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <input type="text" name="message" placeholder="Écrivez votre message..." 
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-xl px-4 py-2.5 flex items-center gap-2 transition">
                        <i class="fas fa-image text-gray-600"></i>
                        <input type="file" name="image" accept="image/*" class="hidden">
                    </label>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
                <p class="text-xs text-gray-400">Vous pouvez joindre une image (JPG, PNG, GIF)</p>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('messages-container');
    if (container) container.scrollTop = container.scrollHeight;
</script>
@endsection