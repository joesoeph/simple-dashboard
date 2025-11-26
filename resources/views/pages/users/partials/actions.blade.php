<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="app.helper.openModal('{{ __('Detail user') }}', '{{ route('system-settings.users.show', $user->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="app.helper.openModal('{{ __('Edit user') }}', '{{ route('system-settings.users.edit', $user->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="app.helper.confirmDelete('{{ route('system-settings.users.destroy', $user->id) }}', {reloadTable: '#userDatatable'})">
        <i class="fas fa-trash"></i>
    </button>
</div>
