@extends('layout.layout')
@section('content')
    <section id="vicall-room" class="vicall-room" data-room="{{ $vicall->room }}">
        <div class="local-user" data-local="{{ $vicall->main_user }}">
            <video muted playsinline></video>
        </div>
        <div class="remote-user">
            <div class="user-info">
                <i class="fa-solid fa-circle-user text-secondary"></i>
                <h4 class="text-light mb-3">{{ $vicall->secondary_user }}</h4>
                <div class="text-light d-flex align-items-center justify-content-center">
                    <span class="spinner-grow spinner-grow-sm me-1"></span>
                    <small>Waiting...</small>
                </div>
            </div>
            <video playsinline></video>
        </div>
    </section>
@endsection