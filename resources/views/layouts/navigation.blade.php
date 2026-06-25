<nav class="sidebar-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('gst-invoices.index') }}" class="nav-item {{ request()->routeIs('gst-invoices.*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice"></i>
        <span>GST Invoices</span>
    </a>
    <a href="{{ route('proformas.index') }}" class="nav-item {{ request()->routeIs('proformas.*') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i>
        <span>Proformas</span>
    </a>
    <a href="{{ route('clients.index') }}" class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Clients</span>
    </a>
    <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fas fa-box"></i>
        <span>Products</span>
    </a>
    <a href="{{ route('reports.gstr1') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar"></i>
        <span>Reports</span>
    </a>

    <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
        <a href="{{ route('company.settings') }}" class="nav-item {{ request()->routeIs('company.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>My Profile</span>
        </a>
    </div>
</nav>