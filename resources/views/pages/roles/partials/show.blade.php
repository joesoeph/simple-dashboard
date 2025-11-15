<div class="container-fluid py-2">
    <div class="mb-3">
        <h5 class="mb-0">
            <i class="fas fa-key text-info mr-2"></i>{{ $role->name }}
        </h5>
        <small class="text-muted">Guard: {{ $role->guard_name }}</small>
    </div>
    <div class="row">
        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">Role ID</label>
            <div class="font-weight-bold">{{ $role->id }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">Guard Name</label>
            <div>{{ $role->guard_name }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">Created At</label>
            <div>{{ $role->created_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">Updated At</label>
            <div>{{ $role->updated_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
    <div class="mt-3">
        <label class="text-muted">Permissions</label>

        @if ($role->permissions->count() === 0)
            <div class="text-muted"><i>This role has no permissions yet.</i></div>
        @else
            <div class="row">
                @foreach ($role->permissions as $permission)
                    <div class="col-md-4 col-6 mb-1">
                        <span class="badge badge-info w-100 p-2">
                            <i class="fas fa-check mr-1"></i> {{ $permission->name }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
