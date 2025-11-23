<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="app.helper.openModal('Detail role', '{{ route('system-settings.roles.show', $role->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="app.helper.openModal('Edit role', '{{ route('system-settings.roles.edit', $role->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="app.helper.confirmDelete('{{ route('system-settings.roles.destroy', $role->id) }}', {reloadTable: '#roleDatatable'})">
        <i class="fas fa-trash"></i>
    </button>
</div>
