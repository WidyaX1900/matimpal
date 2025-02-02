@section('footer')
    <footer class="fixed-bottom">
        <a href="/" class="category active text-decoration-none">
            <i class="fa-solid fa-message"></i>
            <small>Chat</small>
        </a>
        <a href="/videocall" class="category text-decoration-none">
            <i class="fa-solid fa-video"></i>
            <small>Video Call</small>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="category text-decoration-none">
                <i class="fa-solid fa-circle-user"></i>
                <small>Profile</small>
            </button>
        </form>
    </footer>
@endsection
