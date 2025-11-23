@php
    if ($menu->children->count() && $menu->visibleChildren()->isEmpty()) {
        return;
    }
@endphp

<li
    class="nav-item {{ $menu->children->count() ? 'has-treeview' : '' }} {{ $menu->isActive() || $menu->isParentActive() ? 'menu-open' : '' }}">
    <a href="{{ $menu->route ? route($menu->route) : $menu->url ?? '#' }}"
        class="nav-link {{ $menu->isActive() ? 'active' : '' }}">

        <i class="nav-icon {{ $menu->icon }}"></i>
        <p>
            {{ $menu->label }}

            @if ($menu->visibleChildren()->count())
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>

    @if ($menu->visibleChildren()->count())
        <ul class="nav nav-treeview">
            @foreach ($menu->visibleChildren() as $child)
                @include('layouts.sidebar-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
