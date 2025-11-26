@extends('layouts.auth')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url('/') }}"><b>Admin</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">{{ __('Register a new membership') }}</p>

                <!-- Flash Message Sukses -->
                @if (session('status'))
                    <div class="alert alert-success mb-3 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Flash Message Error Umum -->
                @if ($errors->any() && !session('status'))
                    <div class="alert alert-danger mb-3 text-center">
                        {{ __('Please correct the errors below.') }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('Name') }}" value="{{ old('name') }}" id="name"
                            aria-describedby="name-feedback" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>

                        @error('name')
                            <div id="name-feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="{{ __('Email') }}" value="{{ old('email') }}" id="email"
                            aria-describedby="email-feedback" required>
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

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ __('Password') }}" id="password" aria-describedby="password-feedback"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                            <div id="password-feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="{{ __('Confirm Password') }}" id="password_confirmation"
                            aria-describedby="password_confirmation-feedback" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password_confirmation')
                            <div id="password_confirmation-feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-0 mt-3 text-center">
                    <a href="{{ route('login') }}">{{ __('I already have a membership') }}</a>
                </p>
            </div>
            <!-- /.register-card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.register-box -->
@endsection
