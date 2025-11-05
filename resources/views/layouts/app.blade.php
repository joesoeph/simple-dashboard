<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">

        @include('partials.preloader')

        @include('partials.navbar')

        @include('partials.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('partials.footer')

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'system');
    </script>

    @include('partials.scripts')
</body>

</html>
