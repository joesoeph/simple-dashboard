<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="openModal('Detail role', '{{ route('system-settings.roles.show', $role->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="openModal('Edit role', '{{ route('system-settings.roles.edit', $role->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="confirmDelete('{{ route('system-settings.roles.destroy', $role->id) }}', {reloadTable: '#roleDatatable'})">
        <i class="fas fa-trash"></i>
    </button>
</div>
