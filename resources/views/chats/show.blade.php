@extends('layout.layout')
@extends('layout.navbar')
@section('title')
    {{ $friend }}
@endsection
@section('arrow back')
    <a href="/" class="text-dark">
        <i class="fa-solid fa-left-long me-3"></i>
    </a>
@endsection
@section('content')
    <section id="chatPage" class="show-chat-content">
        <ul class="p-0">
            @for ($i = 0; $i < 20; $i++)
                <li class="mb-3 message">
                    <div class="chat-box rounded">
                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, eveniet.</p>
                    </div>
                    <i class="fa-solid fa-sort-down"></i>
                </li>
                <li class="mb-3 my-message">
                    <div class="chat-box rounded">
                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, eveniet.</p>
                    </div>
                    <i class="fa-solid fa-sort-down"></i>
                </li>
            @endfor
        </ul>
    </section>
@endsection
@extends('chats.footer')
