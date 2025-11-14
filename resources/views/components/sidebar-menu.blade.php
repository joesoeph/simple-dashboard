<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>
            User Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-user"></i>
                <p>Users</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('role.index') }}" class="nav-link">
                <i class="fas fa-user-shield"></i>
                <p>Roles</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="nav-link">
                <i class="fas fa-key"></i>
                <p>Permissions</p>
            </a>
        </li>
    </ul>
</li>
