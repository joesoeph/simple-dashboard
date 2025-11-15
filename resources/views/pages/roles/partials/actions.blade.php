<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="openModal('Detail role', '{{ route('roles.show', $role->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="openModal('Edit role', '{{ route('roles.edit', $role->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="confirmDelete('{{ route('roles.destroy', $role->id) }}', '#roleDatatable')">
        <i class="fas fa-trash"></i>
    </button>
</div>
