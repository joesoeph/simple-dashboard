<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="openModal('Detail permission', '{{ route('permissions.show', $permission->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="openModal('Edit permission', '{{ route('permissions.edit', $permission->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="confirmDelete('{{ route('permissions.destroy', $permission->id) }}', '#permissionDatatable')">
        <i class="fas fa-trash"></i>
    </button>
</div>
