<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="app.helper.openModal('Detail permission', '{{ route('system-settings.permissions.show', $permission->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="app.helper.openModal('Edit permission', '{{ route('system-settings.permissions.edit', $permission->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="app.helper.confirmDelete('{{ route('system-settings.permissions.destroy', $permission->id) }}', {reloadTable: '#permissionDatatable'})">
        <i class="fas fa-trash"></i>
    </button>
</div>
