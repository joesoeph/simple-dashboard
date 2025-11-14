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

    <!-- Global Modal -->
    <div class="modal fade" id="globalModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="globalModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="globalModalBody"></div>
            </div>
        </div>
    </div>
</body>

</html>
