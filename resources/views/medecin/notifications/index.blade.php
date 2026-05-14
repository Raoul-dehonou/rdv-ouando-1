@extends('layouts.app')

@section('header_icon', 'fa-bell')
@section('header_title', 'Notifications')
@section('header_subtitle', 'Alertes et rappels')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 mt-8">
    <div class="flex items-center justify-between p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-bell text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                <p class="text-sm text-gray-500">Alertes et rappels</p>
            </div>
        </div>
        <form action="{{ route('medecin.notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-check-double"></i> Tout marquer comme lu
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notif)
            <div class="p-6 {{ $notif->read_at ? 'bg-white hover:bg-gray-50' : 'bg-blue-50 hover:bg-blue-100' }} transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            @if(!$notif->read_at)
                                <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                            @endif
                            <p class="font-semibold text-gray-800">{{ $notif->data['title'] ?? 'Nouvelle notification' }}</p>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $notif->data['message'] ?? '' }}</p>
                        <p class="text-xs text-gray-400 mt-2">
                            <i class="far fa-clock mr-1"></i> {{ $notif->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if(!$notif->read_at)
                    <form action="{{ route('medecin.notifications.read', $notif) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition flex items-center gap-1">
                            <i class="fas fa-check-circle"></i> Marquer comme lu
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bell-slash text-4xl text-blue-600"></i>
                </div>
                <p class="text-gray-500 text-lg font-medium">Aucune notification</p>
                <p class="text-gray-400 text-sm mt-1">Vous serez alerté lors de vos rendez-vous</p>
            </div>
            @endforelse
        </div>
        @if($notifications->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection