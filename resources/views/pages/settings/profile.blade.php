@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Settings') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Profile') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Settings') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active"
                                        href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('user-password.edit') }}">{{ __('Password') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('appearance.edit') }}">{{ __('Appearance') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="row justify-content-md-center">
                                        <div class="col-6">
                                            <h3>{{ __('Profile information') }}</h3>
                                            <p class="text-secondary">{{ __('Update your name and email address') }}</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-6">
                                            <form action="{{ route('profile.update') }}" method="POST">
                                                @method('patch')
                                                @csrf

                                                <!-- Full Name -->
                                                <div class="input-group mb-3">
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="{{ __('Name') }}"
                                                        value="{{ old('name', Auth::user()->name) }}" id="name"
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
                                                    <input type="email" name="email" placeholder="{{ __('Email') }}"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('name', Auth::user()->email) }}" id="email"
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

                                                @if ($mustVerifyEmail && auth()->user()->email_verified_at === null)
                                                    <div class="alert alert-warning alert-dismissible fade show mb-3"
                                                        role="alert">
                                                        <p class="mb-0">
                                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                                            {{ __('Your email address is unverified') }}
                                                            <a href="{{ route('verification.send') }}"
                                                                onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();"
                                                                class="text-primary underline">
                                                                {{ __('Click here to resend the verification email') }}
                                                            </a>
                                                        </p>

                                                        @if (session('status') === 'verification-link-sent')
                                                            <p class="text-success font-weight-bold mb-0 mt-2">
                                                                {{ __('A new verification link has been sent to your email address') }}
                                                            </p>
                                                        @endif

                                                        <form id="resend-verification-form"
                                                            action="{{ route('verification.send') }}" method="POST"
                                                            class="d-none">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                @endif

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Save') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
