@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Permissions</a></li>
                        <li class="breadcrumb-item active">User Management</li>
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
                                onclick="app.helper.openModal('Add new permission', '{{ route('system-settings.permissions.create') }}')">
                                <i class="fas fa-plus"></i>
                                Add new
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="permissionDatatable" class="table-bordered table-striped table-sm table-hover table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Guard Name</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
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
        $(function() {
            const table = $('#permissionDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('system-settings.permissions.datatable') }}",
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
                        data: 'guard_name',
                        name: 'guard_name'
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

            $('#permissionDatatable tbody').on('click', 'tr', function() {
                $('#permissionDatatable tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
            });


            $('#permissionDatatable').on('dblclick', 'tbody tr', function() {
                const data = table.row(this).data();
                if (!data) return;

                app.helper.openModal('Edit permission', `/system-settings/permissions/${data.id}/edit`);
            });
        });
    </script>
@endsection
