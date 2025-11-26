@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Small Boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <div class="icon"><i class="ion ion-bag"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Tambahkan box lain -->
            </div>

            <div class="row">
                <div class="col-lg-12 col-12">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Charts, Chat, To Do List, dll -->
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <!-- Chart Card -->
                </section>
                <section class="col-lg-5 connectedSortable">
                    <!-- Map, Sales Graph, Calendar -->
                </section>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
@endsection
