@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    You forgot your password? Here you can easily retrieve a new password.
                </p>

                <!-- Flash Message: Link Terkirim -->
                @if (session('status'))
                    <div class="alert alert-success mb-3 text-center" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Flash Message Error Umum -->
                @if (session('error'))
                    <div class="alert alert-danger mb-3 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" aria-describedby="email-feedback" required
                            autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <div id="email-feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Request new password') }}
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-1 mt-3 text-center">
                    <a href="{{ route('login') }}">Login</a>
                </p>
                <p class="mb-0 text-center">
                    <a href="{{ route('register') }}">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
