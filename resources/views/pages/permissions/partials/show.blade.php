<div class="container-fluid py-2">
    <div class="mb-3">
        <h5 class="mb-0">
            <i class="fas fa-key text-info mr-2"></i>{{ $permission->name }}
        </h5>
        <small class="text-muted">{{ __('Guard') }}: {{ $permission->guard_name }}</small>
    </div>

    <div class="row">
        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Permission ID') }}</label>
            <div class="font-weight-bold">{{ $permission->id }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Guard Name') }}</label>
            <div>{{ $permission->guard_name }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Created At') }}</label>
            <div>{{ $permission->created_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>

        <div class="col-md-6 col-6 mb-2">
            <label class="text-muted mb-0">{{ __('Updated At') }}</label>
            <div>{{ $permission->updated_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
</div>
