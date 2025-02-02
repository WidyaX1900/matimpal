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
            @foreach ($videocalls as $list)
                <li class="mb-3">
                    <a>
                        <i class="fa-solid fa-circle-user text-secondary"></i>
                        <div class="vicall-info">
                            <div class="friend-info">
                                <strong>{{ $list->user->name }}</strong>
                                <small class="text-secondary">
                                    @if ($list->status === 'missed call' || $list->status === 'rejected')
                                       <i class="fa-solid fa-video-slash text-danger"></i> 
                                    @else
                                       <i class="fa-solid fa-video text-success"></i> 
                                    @endif

                                    @if ($list->status === 'missed call' || $list->status === 'rejected')
                                       {{ Str::ucfirst($list->status) }} 
                                    @else
                                        @if ($list->direction === 'outgoing')
                                            Outgoing call
                                        @else
                                            Incoming call
                                        @endif 
                                    @endif
                                </small>
                            </div>
                        </div>
                        <i class="fa-solid fa-video vicall-icon" data-receiver="{{ $list->user->name }}"></i>
                    </a>
                </li>
            @endforeach
        </ul>
        <a href="/videocall/newcall" class="new-vicall-btn">
            <i class="fa-solid fa-video"></i>
        </a>    
    </section>
@endsection
@extends('layout.footer')
