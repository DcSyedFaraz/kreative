<ul id="side-menu-baer">
    <li class="menu-title">Menu</li>
    <li class="{{ request()->routeIs('dashboard') ? 'menuitem-active' : '' }}">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-feather="home"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('profile.*') ? 'menuitem-active' : '' }}">
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i data-feather="globe"></i>
            <span> Edit Profile </span>
        </a>
    </li>
    <li class="{{ request()->routeIs('custom-packages.*') ? 'menuitem-active' : '' }}">
        <a href="{{ route('custom-packages.index') }}" class="{{ request()->routeIs('custom-packages.*') ? 'active' : '' }}">
            <i data-feather="globe"></i>
            <span> custom-packages </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('chat.*') ? 'menuitem-active' : '' }}">
        <a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}">
            <i data-feather="message-circle"></i>
            <span> Chat Rooms </span>
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
            @endif
        </a>
    </li>

    <li>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="btn btn-danger" style="margin-left:15px;">
            Logout
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
