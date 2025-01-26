@extends('layout.layout')
@section('content')
    <section id="vicall-room" class="vicall-room" data-room="{{ $vicall->room }}">
        <div class="local-user" data-local="{{ $vicall->main_user }}">
            <video muted playsinline></video>
        </div>
        <div class="remote-user">
            <h1 class="text-light">{{ $vicall->secondary_user }}</h1>
        </div>
    </section>
@endsection