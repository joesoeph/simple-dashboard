@extends('layouts.front')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
            </div>

            <div class="col-lg-12 col-12">
                @auth
                    <h1 class="mb-4">Welcome {{ Auth::user()->name ?? '' }}</h1>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                @endauth
                @guest
                    <h1 class="mb-4">Welcome {{ Auth::user()->name ?? '' }}</h1>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">Register</a>
                @endguest
            </div>
        </div>
    </div>
@endsection
