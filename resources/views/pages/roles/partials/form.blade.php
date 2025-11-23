@php
    $guards = ['web']; // bisa ambil dari config atau database juga
@endphp
<form onsubmit="return app.helper.submitForm(this, '#roleDatatable')" action="{{ $action }}">
    @csrf
    @if (isset($role))
        @method('PUT')
    @endif
    <div id="formErrors"></div>
    <div class="form-group">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ $role->name ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="guard_name">Guard name</label>
        <select id="guard_name" class="form-control select2bs4" name="guard_name" style="width: 100%;">
            @foreach ($guards as $guard)
                <option value="{{ $guard }}" {{ $guard == ($role->guard_name ?? '') ? 'selected' : '' }}>
                    {{ $guard }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Permissions</label>
        <div class="row">
            @foreach ($permissions as $permission)
                <div class="col-md-4">
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="permission_{{ $permission->id }}"
                            name="permissions[]" value="{{ $permission->name }}" @checked($role && $role->hasPermissionTo($permission->name))>
                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
