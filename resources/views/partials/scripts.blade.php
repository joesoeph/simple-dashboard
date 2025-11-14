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

<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>

<!-- AXIOS -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

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

        // Initial on modal
        $('.modal').on('shown.bs.modal', function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                dropdownParent: $('.modal')
            });
        });

        // Initial on all pages
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });
    });

    function openModal(title, url) {
        $('#globalModalTitle').text(title);
        $('#globalModalBody').html('<div class="text-center p-3">Loading...</div>');
        $('#globalModal').modal('show');

        axios.get(url).then(res => {
            $('#globalModalBody').html(res.data);
        }).catch(() => {
            $('#globalModalBody').html('<div class="alert alert-danger">Failed fetch data</div>');
        });
    }

    function submitForm(form, idTable) {
        const url = form.action;
        const data = new FormData(form);
        const overlay = `
            <div class="form-overlay d-flex align-items-center justify-content-center" style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.6);z-index:10;">
                <div class="spinner-border text-primary" role="status"></div>
            </div>`;

        $(form).css('position', 'relative').append(overlay);

        axios.post(url, data)
            .then(res => {
                $('#globalModal').modal('hide');
                toastr.success(res.data.message || 'Saved successfully');
                $(idTable).DataTable().ajax.reload(null, false);
            })
            .catch(err => {
                if (err.response?.data?.errors) {
                    const errorList = Object.values(err.response.data.errors)
                        .flat()
                        .map(msg => `<li>${msg}</li>`)
                        .join('');

                    $('#formErrors').html(`
                        <div class="alert alert-danger mb-3" role="alert">
                            <div class="fw-bold mb-1">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Please fix the following errors:
                            </div>
                            <ul class="mb-0 ps-3">${errorList}</ul>
                        </div>
                    `);
                } else {
                    toastr.error('An error occurred!');
                }
            }).finally(() => {
                $(form).find('.form-overlay').remove();
            });
        return false;
    }

    function confirmDelete(url, idTable) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(url)
                    .then(res => {
                        Swal.fire('Deleted!', res.data.message || 'The data has been deleted.', 'success');
                        $(idTable).DataTable().ajax.reload(null, false);
                    })
                    .catch(() => {
                        Swal.fire('Failed', 'An error occurred while deleting the data.', 'error');
                    });
            }
        });
    }
</script>

@yield('scripts')
