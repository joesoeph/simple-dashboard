<div class="btn-group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="openModal('Detail user', '{{ route('users.show', $user->id) }}')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="openModal('Edit user', '{{ route('users.edit', $user->id) }}')">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="confirmDelete('{{ route('users.destroy', $user->id) }}', '#userDatatable')">
        <i class="fas fa-trash"></i>
    </button>
</div>
