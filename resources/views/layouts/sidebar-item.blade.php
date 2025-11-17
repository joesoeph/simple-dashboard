<li
    class="nav-item {{ $menu->children->count() ? 'has-treeview' : '' }} {{ $menu->isActive() || $menu->isParentActive() ? 'menu-open' : '' }}">
    <a href="{{ $menu->route ? route($menu->route) : $menu->url ?? '#' }}"
        class="nav-link {{ $menu->isActive() ? 'active' : '' }}">

        <i class="nav-icon {{ $menu->icon }}"></i>
        <p>
            {{ $menu->label }}
            @if ($menu->children->count())
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>

    @if ($menu->children->count())
        <ul class="nav nav-treeview">
            @foreach ($menu->children as $child)
                <li class="nav-item">
                    <a href="{{ $child->route ? route($child->route) : $child->url ?? '#' }}"
                        class="nav-link {{ $child->isActive() ? 'active' : '' }}">

                        <i class="nav-icon far fa-circle nav-icon"></i>
                        <p>{{ $child->label }}</p>
                    </a>

                    {{-- recursive include --}}
                    @if ($child->children->count())
                        @include('layouts.sidebar-item', ['menu' => $child])
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</li>
