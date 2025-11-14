<form onsubmit="return submitForm(this, '#userDatatable')" action="{{ $action }}">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif
    <div id="formErrors"></div>
    <div class="form-group">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ $user->name ?? '' }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ $user->email ?? '' }}" class="form-control">
    </div>
    @if (!isset($user))
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control">
        </div>
    @endif
    <button type="submit" class="btn btn-primary">Save</button>
</form>
