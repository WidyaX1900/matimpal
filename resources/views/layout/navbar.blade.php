@section('navbar')
    <nav class="fixed-top">
        @yield('arrow back')
        <h4 class="mb-0">@yield('title')</h4>
    </nav>
    <div class="videocall-container d-none">
        <div class="friend-info">
            <i class="fa-solid fa-circle-user text-secondary"></i>
            <h6></h6>
        </div>
        <div class="vicall-navigator vicall-navigator--center"></div>
    </div>
    <audio id="callSfx" src="{{ config('app.asset_url') }}audio/phone-call.mp3"></audio>
@endsection
