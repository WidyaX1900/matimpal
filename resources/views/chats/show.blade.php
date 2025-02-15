@extends('layout.layout')
@extends('layout.navbar')
@section('title')
    {{ $friend->name }}
@endsection
@section('arrow back')
    <a href="/" class="text-dark">
        <i class="fa-solid fa-left-long me-3"></i>
    </a>
@endsection
@section('content')
    <section id="chatPage" class="show-chat-content" data-friend="{{ $friend->username }}">
        <ul class="p-0"></ul>
    </section>
@endsection
@extends('chats.footer')
