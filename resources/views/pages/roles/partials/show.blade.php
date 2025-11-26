<div class="container-fluid py-2">
    <div class="mb-3">
        <h5 class="mb-0">
            <i class="fas fa-key text-info mr-2"></i>{{ $role->name }}
        </h5>
        <small class="text-muted">{{ __('Guard') }}: {{ $role->guard_name }}</small>
    </div>
    <div class="row">
        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Role ID') }}</label>
            <div class="font-weight-bold">{{ $role->id }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Guard Name') }}</label>
            <div>{{ $role->guard_name }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Created At') }}</label>
            <div>{{ $role->created_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Updated At') }}</label>
            <div>{{ $role->updated_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
    <div class="mt-3">
        <label class="text-muted">{{ __('Permissions') }}</label>

        @if ($role->permissions->count() === 0)
            <div class="text-muted"><i>{{ __('This role has no permissions yet') }}</i></div>
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
