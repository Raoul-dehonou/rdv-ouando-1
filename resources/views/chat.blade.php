@extends('layouts.app')

@section('header_icon', 'fa-comment-dots')
@section('header_title', 'Messagerie')
@section('header_subtitle', 'Boite de réception')

@section('content')
<div class="max-w-4xl mx-auto h-[calc(100vh-180px)] mt-8">
    @livewire('chat', ['userId' => $userId])
</div>
@endsection
