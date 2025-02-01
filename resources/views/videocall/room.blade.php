@extends('layout.layout')
@section('content')
    <section id="vicall-room" class="vicall-room" data-room="{{ $vicall->room }}">
        <div class="local-user" data-local="{{ $vicall->main_user }}">
            <video muted playsinline data-audio="{{ $vicall->audio }}" data-camera="{{ $vicall->camera }}"></video>
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
        <div class="vicall-navigator">
            @if ($vicall->audio === 'true')
                <button type="button" class="btn rounded-circle audio-btn">
                    <i class="fa-solid fa-microphone text-light"></i>
                </button>    
            @else
                <button type="button" class="btn rounded-circle audio-btn">
                    <i class="fa-solid fa-microphone-slash text-danger"></i>
                </button>                
            @endif
            @if ($vicall->camera === 'true')
                <button type="button" class="btn rounded-circle camera-btn">
                    <i class="fa-solid fa-camera text-light"></i>
                </button>
            @else
                <button type="button" class="btn rounded-circle camera-btn">
                    <i class="fa-solid fa-camera text-danger"></i>
                </button>
            @endif
            <button type="button" class="btn btn-danger rounded-circle close-vicall-btn">
                <i class="fa-solid fa-video-slash"></i>
            </button>
        </div>
    </section>
@endsection