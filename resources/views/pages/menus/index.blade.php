@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Menu') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Menu') }}</a></li>
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
                    <x-alert />
                    <div class="card">
                        <div class="card-header text-right">
                            <button type="button" class="btn btn-primary"
                                onclick="app.helper.openModal('{{ __('Add New') }}', '{{ route('system-settings.menus.create') }}')">
                                <i class="fas fa-plus"></i>
                                {{ __('Add New') }}
                            </button>
                            <button id="save-order" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                {{ __('Save Position') }}
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="menu-nested" class="list-group">

                                @foreach ($menusManagement as $menu)
                                    <div class="list-group-item" data-id="{{ $menu->id }}">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ __($menu->label) }}</strong>
                                                <span class="badge {{ $menu->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $menu->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </div>

                                            <div>
                                                <button type="button" class="btn btn-xs"
                                                    onclick="app.helper.openModal('{{ __('Edit menu') }}', '{{ route('system-settings.menus.edit', $menu) }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-xs"
                                                    onclick="app.helper.confirmDelete('{{ route('system-settings.menus.destroy', $menu) }}', {
                                                        onSuccess: () => {
                                                            window.location.reload();
                                                        }
                                                    })">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- children -->
                                        @if ($menu->children->count())
                                            <div class="nested-list list-group mt-2">
                                                @foreach ($menu->children as $child)
                                                    <div class="list-group-item" data-id="{{ $child->id }}">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <strong>{{ __($child->label) }}</strong>
                                                                <span
                                                                    class="badge {{ $child->is_active ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $child->is_active ? __('Active') : __('Inactive') }}
                                                                </span>
                                                            </div>

                                                            <div>
                                                                <button type="button" class="btn btn-xs"
                                                                    onclick="app.helper.openModal('{{ __('Edit menu') }}', '{{ route('system-settings.menus.edit', $child) }}')">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-xs"
                                                                    onclick="app.helper.confirmDelete('{{ route('system-settings.menus.destroy', $child) }}', {
                                                                        onSuccess: () => {
                                                                            window.location.reload();
                                                                        }
                                                                    })">
                                                                    <i class="fas fa-trash text-danger"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if ($child->children->count())
                                                            <div class="nested-list list-group mt-2">
                                                                @foreach ($child->children as $g)
                                                                    <div class="list-group-item"
                                                                        data-id="{{ $g->id }}">
                                                                        {{ $g->label }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('adminlte/plugins/sortable/sortable.min.js') }}"></script>

    <script>
        let nestedSortables = [];

        $(document).ready(function() {
            // Init all nested sortable lists
            $('.list-group').each(function() {
                const sortable = new Sortable(this, {
                    animation: 150,
                    group: 'nested',
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    handle: '.list-group-item'
                });

                nestedSortables.push(sortable);
            });

            // Save Button
            $('#save-order').on('click', function() {
                const root = $('#menu-nested')[0];
                const data = buildTree($(root));

                axios.post("{{ route('system-settings.menus.reorder') }}", {
                    tree: data
                }).then(res => {
                    toastr.success("Menu position has been successfully saved!");
                }).catch(err => {
                    toastr.error("Failed to save the menu position.");
                });
            });
        });

        // Convert nested DOM structure → JSON tree
        function buildTree($container) {
            const items = $container.children('.list-group-item');

            return items.map(function() {
                const $item = $(this);
                const id = $item.data('id');
                const $childrenContainer = $item.children('.nested-list');

                return {
                    id,
                    children: $childrenContainer.length ? buildTree($childrenContainer) : []
                };
            }).get();
        }
    </script>
@endsection
