@extends('layout.layout')
@extends('layout.navbar')
@section('title', 'Chat')
@section('content')
    <section class="chat-content">
        @if ($chats->isEmpty())
            <div class="vh-100 d-flex justify-content-center align-items-center">
                No Chat Available
            </div>
        @else
            <ul class="p-0">
                @foreach ($chats as $chat)
                    <li class="mb-3">
                        <a href="/chat/show/{{ $chat->lawan_chat }}">
                            <i class="fa-solid fa-circle-user"></i>
                            <div class="chat-info">
                                <div class="friend-info">
                                    <strong>{{ $chat->name }}</strong>
                                    <small>{{ $chat->message }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>            
        @endif
        <a href="/friend" class="new-chat-btn">
            <i class="fa-solid fa-message"></i>
        </a>
    </section>
@endsection
@extends('layout.footer')
