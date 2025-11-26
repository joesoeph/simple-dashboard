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
                        <li class="breadcrumb-item"><a href="#">{{ __('Password') }}</a></li>
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
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link active"
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
                                            <h3>{{ __('Update password') }}</h3>
                                            <p class="text-secondary">
                                                {{ __('Ensure your account is using a long, random password to stay secure') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-6">
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <form action="{{ route('user-password.update') }}" method="POST">
                                                @method('put')
                                                @csrf

                                                <!-- Current Password -->
                                                <div class="input-group mb-3">
                                                    <input type="password" name="current_password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        placeholder="{{ __('Current password') }}"
                                                        value="{{ old('current_password') }}" id="current_password"
                                                        aria-describedby="current_password-feedback" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>

                                                    @error('current_password')
                                                        <div id="current_password-feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <!-- Password -->
                                                <div class="input-group mb-3">
                                                    <input type="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Password" value="{{ old('password') }}" id="password"
                                                        aria-describedby="password-feedback" />
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

                                                <!-- Password Confirmation -->
                                                <div class="input-group mb-3">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        placeholder="{{ __('Confirm password') }}"
                                                        value="{{ old('password_confirmation') }}"
                                                        id="password_confirmation"
                                                        aria-describedby="password_confirmation-feedback" />
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
