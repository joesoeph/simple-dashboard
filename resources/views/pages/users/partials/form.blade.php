<form onsubmit="return app.helper.submitForm(this, '#userDatatable')" action="{{ $action }}">
    @csrf
    @isset($user)
        @method('PUT')
    @endisset

    <div id="formErrors"></div>

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name ?? '' }}" class="form-control">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email ?? '' }}" class="form-control">
    </div>

    @empty($user)
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
    @endempty

    {{-- ROLES --}}
    <div class="form-group">
        <label>Roles</label>
        <select name="roles[]" class="form-control select2bs4" multiple>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    @isset($user)
                        {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}
                    @endisset>
                    {{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- PERMISSIONS --}}
    <div class="form-group">
        <label>Permissions</label>
        <select name="permissions[]" class="form-control select2bs4" multiple>
            @foreach ($permissions as $permission)
                <option value="{{ $permission->name }}"
                    @isset($user)
                        {{ $user->permissions->contains('name', $permission->name) ? 'selected' : '' }}
                    @endisset>
                    {{ $permission->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Save</button>
</form>
