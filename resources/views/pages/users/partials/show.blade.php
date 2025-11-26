<div class="container-fluid px-2 py-2">
    <div class="d-flex align-items-center mb-3">
        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center mr-3 text-white"
            style="width:60px;height:60px;font-size:22px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h5 class="mb-0">{{ $user->name }}</h5>
            <small class="text-muted">{{ $user->email }}</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-6">
            <div class="form-group mb-2">
                <label class="text-muted mb-0">{{ __('User ID') }}</label>
                <div class="font-weight-bold">{{ $user->id }}</div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group mb-2">
                <label class="text-muted mb-0">{{ __('Email Verified') }}</label>
                <div>
                    @if ($user->email_verified_at)
                        <span class="badge badge-success">{{ __('Verified') }}</span>
                    @else
                        <span class="badge badge-secondary">{{ __('Unverified') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group mb-2">
                <label class="text-muted mb-0">{{ __('Created At') }}</label>
                <div>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group mb-2">
                <label class="text-muted mb-0">{{ __('Updated At') }}</label>
                <div>{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</div>
            </div>
        </div>
    </div>
</div>
