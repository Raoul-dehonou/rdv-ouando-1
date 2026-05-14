@extends('layouts.app')

@section('header_icon', 'fa-comment-dots')
@section('header_title', 'Messagerie')
@section('header_subtitle', 'Discutez avec vos patients')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
   

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 mt-8">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-users text-blue-600"></i>
                Mes contacts
            </h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($contacts ?? [] as $contact)
                <a href="{{ route('medecin.messagerie.show', $contact->id) }}" class="flex items-center p-4 hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
                        <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                    </div>
                    @php
                        $unread = isset($contact->id) ? auth()->user()->receivedMessages()->where('sender_id', $contact->id)->where('is_read', false)->count() : 0;
                    @endphp
                    @if($unread > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unread }}</span>
                    @endif
                    <i class="fas fa-chevron-right text-gray-400 ml-4"></i>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-comment-slash text-4xl mb-3 opacity-50"></i>
                    <p>Aucun contact disponible.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection