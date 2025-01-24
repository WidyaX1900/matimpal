@section('navbar')
    <nav class="fixed-top" data-user="{{ Auth::user()->name }}">
        @yield('arrow back')
        <h4 class="mb-0">@yield('title')</h4>
    </nav>
    <div class="videocall-container d-none">
        <div class="friend-info">
            <i class="fa-solid fa-circle-user text-secondary"></i>
            <h6></h6>
            <small class="text-light"></small>
        </div>
        <div class="vicall-navigator vicall-navigator--center"></div>
    </div>
    <audio id="callSfx" src="{{ config('app.asset_url') }}audio/phone-call.mp3"></audio>
    <audio id="ringtone" src="{{ config('app.asset_url') }}audio/ringtone.mp3"></audio>
@endsection
