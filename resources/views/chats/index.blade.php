@extends('layout.layout')
@extends('layout.navbar')
@section('title', 'Chat')
@section('content')
    <section class="chat-content">
        <ul class="p-0">
            @for ($i = 0; $i < 10; $i++)
                <li class="mb-3">
                    <a href="/chat/show">
                        <i class="fa-solid fa-circle-user"></i>
                        <div class="chat-info">
                            <div class="friend-info">
                                <strong>Friend Name</strong>
                                <small>Last message</small>
                            </div>
                            <small>19/01/2025</small>
                        </div>
                    </a>
                </li>
            @endfor
        </ul>
        <a href="" class="new-chat-btn">
            <i class="fa-solid fa-message"></i>
        </a>
    </section>
@endsection
@extends('layout.footer')
