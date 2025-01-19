@extends('layout.layout')
@extends('layout.navbar')
@section('title', 'Friends')
@section('arrow back')
    <a href="/" class="text-dark">
        <i class="fa-solid fa-left-long me-3"></i>
    </a>
@endsection
@section('content')
    <section class="chat-content">
        <ul class="p-0 friend-list">
            @for ($i = 0; $i < 10; $i++)
                <li class="mb-3">
                    <a href="/chat/show">
                        <i class="fa-solid fa-circle-user"></i>
                        <div class="chat-info">
                            <div class="friend-info">
                                <strong>Friend Name</strong>
                            </div>
                        </div>
                    </a>
                </li>
            @endfor
        </ul>
    </section>
@endsection
