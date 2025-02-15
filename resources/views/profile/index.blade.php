@extends('layout.layout')
@extends('layout.navbar')
@section('title', 'Profile')
@section('content')
    <section class="profile">
        <div class="row user-info align-items-start">
            <div class="col-2 p-0 me-2">
                <i class="fa-solid fa-circle-user text-secondary"></i>
            </div>
            <div class="col p-0">
                <h5 class="mb-1">{{ $user->name }}</h5>
                <small class="text-secondary">{{ $user->username }}</small>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="d-block w-100 btn text-danger text-start shadow-sm p-3">
                    <i class="fa-solid fa-right-from-bracket me-1"></i>
                    <small>Logout</small>
                </button>
            </form>
        </div>
    </section>
@endsection
@extends('layout.footer')
