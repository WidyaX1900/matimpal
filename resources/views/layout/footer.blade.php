@section('footer')
    <footer class="fixed-bottom">
        <a href="/" class="category text-decoration-none {{ request()->is('/') ? 'active' : '' }}">
            <i class="fa-solid fa-message"></i>
            <small>Chat</small>
        </a>
        <a href="/videocall" class="category text-decoration-none {{ request()->is('videocall') ? 'active' : '' }}">
            <i class="fa-solid fa-video"></i>
            <small>Video Call</small>
        </a>
        <a href="/profile" class="category text-decoration-none {{ request()->is('profile') ? 'active' : '' }}">
            <i class="fa-solid fa-circle-user"></i>
            <small>Profile</small>
        </a>
    </footer>
@endsection
