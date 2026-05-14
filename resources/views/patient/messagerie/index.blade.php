@extends('layouts.app')

@section('header_icon', 'fa-comment-dots')
@section('header_title', 'Messagerie')
@section('header_subtitle', 'Discutez avec vos médecins')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mt-8">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-comment-dots text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Messagerie</h1>
                <p class="text-sm text-gray-500">Boite de réception</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium border border-blue-200">
            <i class="fas fa-envelope mr-2"></i> Messages
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-semibold text-gray-800 flex items-center">
                <i class="fas fa-users text-blue-600 mr-2"></i>
                Mes contacts
            </h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($contacts as $contact)
                <a href="{{ route('chat.show', $contact->id) }}" class="flex items-center p-4 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition group">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
                        <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                    </div>
                    @php
                        $unread = auth()->user()->receivedMessages()->where('sender_id', $contact->id)->where('is_read', false)->count();
                    @endphp
                    @if($unread > 0)
                        <span class="bg-red-500 text-white text-xs font-medium px-2 py-1 rounded-full">{{ $unread }}</span>
                    @endif
                    <i class="fas fa-chevron-right text-gray-400 ml-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            @empty
                <div class="py-16 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comment-slash text-4xl text-blue-600"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-medium">Aucun contact disponible</p>
                    <p class="text-gray-400 text-sm mt-1">Les médecins avec qui vous échangez apparaîtront ici</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection