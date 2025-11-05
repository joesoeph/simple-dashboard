@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Appearance</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                                <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('user-password.edit') }}">Password</a>
                                </li>
                                <li class="nav-item"><a class="nav-link active"
                                        href="{{ route('appearance.edit') }}">Appearance</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="form-group">
                                        <label>Theme Preference</label>
                                        <div class="btn-group btn-group-toggle d-block" data-toggle="buttons">
                                            <label class="btn btn-outline-primary theme-btn" data-theme="light">
                                                <input type="radio" name="theme" autocomplete="off">
                                                <i class="fas fa-sun mr-1"></i> Light
                                            </label>
                                            <label class="btn btn-outline-primary theme-btn" data-theme="dark">
                                                <input type="radio" name="theme" autocomplete="off">
                                                <i class="fas fa-moon mr-1"></i> Dark
                                            </label>
                                            <label class="btn btn-outline-primary theme-btn" data-theme="system">
                                                <input type="radio" name="theme" autocomplete="off">
                                                <i class="fas fa-laptop mr-1"></i> System
                                            </label>
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
