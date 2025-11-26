@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Users') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Users') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('System Settings') }}</li>
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
                        <div class="card-header text-right">
                            <button type="button" class="btn btn-primary"
                                onclick="app.helper.openModal('{{ __('Add New') }}', '{{ route('system-settings.users.create') }}')">
                                <i class="fas fa-plus"></i>
                                {{ __('Add New') }}
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="userDatatable" class="table-bordered table-striped table-sm table-hover table">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Roles') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data akan di-load via AJAX --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const table = $('#userDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('system-settings.users.datatable') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles',
                    render: function(value) {
                        if (!value) return '-';
                        return value.split(', ').map(r =>
                            `<span class="badge badge-primary mr-1">${r}</span>`
                        ).join('');
                    }
                },
                {
                    data: 'permissions',
                    name: 'permissions',
                    render: function(value) {
                        if (!value) return '-';
                        return value.split(', ').map(p =>
                            `<span class="badge badge-info mr-1">${p}</span>`
                        ).join('');
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    width: '30px',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ], // Default sort by ID descending
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            language: {
                processing: "Loading...",
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                emptyTable: "No data available"
            }
        });

        $('#userDatatable tbody').on('click', 'tr', function() {
            $('#userDatatable tbody tr').removeClass('selected-row');
            $(this).addClass('selected-row');
        });


        $('#userDatatable').on('dblclick', 'tbody tr', function() {
            const data = table.row(this).data();
            if (!data) return;

            app.helper.openModal('Edit user', `/system-settings/users/${data.id}/edit`);
        });
    </script>
@endsection
