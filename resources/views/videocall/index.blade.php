@extends('layout.layout')
@extends('layout.navbar')
@section('title', 'Video Call')
@section('arrow back')
    <a href="/" class="text-dark">
        <i class="fa-solid fa-left-long me-3"></i>
    </a>
@endsection
@section('content')
    <section class="videocall-content">
        <ul class="p-0 friend-list">
            @for ($i = 1; $i <= 5; $i++)
                <li class="mb-3">
                    <a>
                        <i class="fa-solid fa-circle-user text-secondary"></i>
                        <div class="vicall-info">
                            <div class="friend-info">
                                <strong>Friend Name</strong>
                                <small>Status vicall</small>
                            </div>
                        </div>
                        <i class="fa-solid fa-video vicall-icon"></i>
                    </a>
                </li>
            @endfor
        </ul>    
    </section>
@endsection
