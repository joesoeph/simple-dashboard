@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-3 text-center" role="alert">
                        {{ __('A new verification link has been sent to your email address') }}
                    </div>
                @endif

                <p class="mb-4 text-center">
                    {{ __('Before proceeding, please check your email for a verification link. If you did not receive the email, click the button below.') }}
                </p>

                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf

                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-secondary btn-block">
                                <i class="fas fa-envelope mr-2"></i>
                                {{ __('Resend Verification Email') }}
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-0 text-center">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </p>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
