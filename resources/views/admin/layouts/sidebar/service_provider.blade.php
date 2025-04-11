<ul id="side-menu-baer">
    <li class="menu-title">Menu</li>
    <li class="{{ request()->routeIs('dashboard') ? 'menuitem-active' : '' }}">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-feather="home"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('profile.index') ? 'menuitem-active' : '' }}">
        <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <i data-feather="user"></i>
            <span> Profile </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('profile.personal-info') ? 'menuitem-active' : '' }}">
        <a href="{{ route('profile.personal-info') }}"
            class="{{ request()->routeIs('profile.personal-info') ? 'active' : '' }}">
            <i data-feather="info"></i>
            <span> Personal Info </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('profile.profile-picture') ? 'menuitem-active' : '' }}">
        <a href="{{ route('profile.profile-picture') }}"
            class="{{ request()->routeIs('profile.profile-picture') ? 'active' : '' }}">
            <i data-feather="image"></i>
            <span> Profile Picture </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('profile.business-info') ? 'menuitem-active' : '' }}">
        <a href="{{ route('profile.business-info') }}"
            class="{{ request()->routeIs('profile.business-info') ? 'active' : '' }}">
            <i data-feather="briefcase"></i>
            <span> Business Info </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('services.*') ? 'menuitem-active' : '' }}">
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
            <i data-feather="settings"></i>
            <span> Available Services </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('reviews.index') ? 'menuitem-active' : '' }}">
        <a href="{{ route('reviews.index') }}" class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}">
            <i data-feather="star"></i>
            <span> My Reviews </span>
        </a>
    </li>

    <li class="{{ request()->routeIs('customer-reviews.*') ? 'menuitem-active' : '' }}">
        <a href="{{ route('customer-reviews.index') }}"
            class="{{ request()->routeIs('customer-reviews.*') ? 'active' : '' }}">
            <i data-feather="message-square"></i>
            <span> Review Customers </span>
        </a>
    </li>

    <li>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="btn btn-danger" style="margin-left:15px;">
            <i data-feather="log-out"></i>
            Logout
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
