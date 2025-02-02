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
            @foreach ($friends as $friend)
                <li class="mb-3">
                    <a>
                        <i class="fa-solid fa-circle-user text-secondary"></i>
                        <div class="chat-info">
                            <div class="friend-info">
                                <strong>{{ $friend->name }}</strong>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>    
    </section>
@endsection
