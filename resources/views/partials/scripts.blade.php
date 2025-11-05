<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ChartJS & Plugins -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
<script>
    $(function() {
        const $body = $('body');
        const $root = $('html');
        const $navbar = $('.main-header.navbar');
        const $buttons = $('.theme-btn');

        // Apply theme + set active button + update navbar
        function applyTheme(theme) {
            let isDark = false;

            // Determine if dark mode should be applied
            if (theme === 'dark') {
                isDark = true;
            } else if (theme === 'light') {
                isDark = false;
            } else {
                // system
                isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            // Update body and html classes
            $body.toggleClass('dark-mode', isDark);
            $root.toggleClass('dark', isDark);

            // Update navbar classes
            if (isDark) {
                $navbar.removeClass('navbar-white navbar-light')
                    .addClass('bg-dark navbar-dark');
            } else {
                $navbar.removeClass('bg-dark navbar-dark')
                    .addClass('navbar-white navbar-light');
            }

            // Set active button
            $buttons.removeClass('active');
            $buttons.find('input[type="radio"]').prop('checked', false);

            const $activeBtn = $(`.theme-btn[data-theme="${theme}"]`);
            $activeBtn.addClass('active');
            $activeBtn.find('input[type="radio"]').prop('checked', true);

            // Save to localStorage
            localStorage.setItem('theme', theme);
        }

        // Load saved theme immediately on page load
        const savedTheme = localStorage.getItem('theme') || 'system';
        applyTheme(savedTheme);

        // Click handler
        $buttons.on('click', function(e) {
            e.preventDefault();
            const theme = $(this).data('theme');
            applyTheme(theme);
        });

        // System change listener
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
            if (localStorage.getItem('theme') === 'system') {
                applyTheme('system');
            }
        });
    });
</script>

@yield('scripts')
