@extends('layouts.app')

@section('header_icon', 'fa-comment-dots')
@section('header_title', 'Conversation')
@section('header_subtitle', 'Avec Dr. ' . $contact->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-comment-dots text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Conversation</h1>
                <p class="text-sm text-gray-500">Avec Dr. {{ $contact->name }}</p>
            </div>
        </div>
        <a href="{{ route('patient.messagerie.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-6 h-[500px] overflow-y-auto space-y-4 bg-gray-50" id="messages">
            @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] {{ $msg->sender_id == Auth::id() ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : 'bg-white text-gray-800 border border-gray-200' }} rounded-xl px-4 py-2 shadow-sm">
                    <p class="text-sm">{{ $msg->message }}</p>
                    <p class="text-xs {{ $msg->sender_id == Auth::id() ? 'text-blue-200' : 'text-gray-400' }} mt-1">
                        {{ $msg->created_at->format('H:i') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comment-slash text-4xl text-blue-600"></i>
                </div>
                <p class="text-gray-500 text-lg font-medium">Aucun message</p>
                <p class="text-gray-400 text-sm">Envoyez votre premier message</p>
            </div>
            @endforelse
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-white">
            <form action="{{ route('patient.messagerie.send', $contact->id) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="message" required placeholder="Écrivez votre message..." 
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const messagesDiv = document.getElementById('messages');
    if (messagesDiv) {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
</script>
@endsection