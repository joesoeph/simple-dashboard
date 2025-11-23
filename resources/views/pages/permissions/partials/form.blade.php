@php
    $guards = ['web']; // bisa ambil dari config atau database juga
@endphp
<form onsubmit="return app.helper.submitForm(this, '#permissionDatatable')" action="{{ $action }}">
    @csrf
    @if (isset($permission))
        @method('PUT')
    @endif
    <div id="formErrors"></div>
    <div class="form-group">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ $permission->name ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="guard_name">Guard name</label>
        <select id="guard_name" class="form-control select2bs4" name="guard_name" style="width: 100%;">
            @foreach ($guards as $guard)
                <option value="{{ $guard }}" {{ $guard == ($permission->guard_name ?? '') ? 'selected' : '' }}>
                    {{ $guard }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
