<form action="{{ $action }}" method="POST">
    @csrf
    @if (isset($menu))
        @method('PUT')
    @endif
    <div id="formErrors"></div>
    <div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input id="name" type="text" name="name" value="{{ $menu->name ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="label">{{ __('Label') }}</label>
        <input id="label" type="text" name="label" value="{{ $menu->label ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="icon">{{ __('Icon') }}</label>
        <input id="icon" type="text" name="icon" value="{{ $menu->icon ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="route">{{ __('Route') }}</label>
        <select id="route" class="form-control select2bs4" name="route" style="width: 100%;">
            <option value="">—</option>
            @foreach ($routes as $route)
                <option value="{{ $route['name'] }}" {{ $route['name'] === ($menu->route ?? '') ? 'selected' : '' }}>
                    {{ $route['name'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="parent_id">{{ __('Parent menu') }}</label>
        <select id="parent_id" class="form-control select2bs4" name="parent_id" style="width: 100%;">
            <option value="">—</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}"
                    {{ (string) $parent->id === (string) ($menu->parent_id ?? '') ? 'selected' : '' }}>
                    {{ $parent->label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="order">{{ __('Order') }}</label>
        <input id="order" type="number" name="order" value="{{ $menu->order ?? '0' }}" class="form-control">
    </div>
    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                {{ !empty($menu) && $menu->is_active ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">{{ __('Active') }}?</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
</form>
