<div class="sidebar">

    <div>

        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/butterbake.png')}}" alt ="butter bake">
            </div>

            <div class="sidebar-brand-text">
                <div class="logo">Butter Bake</div>
                <div class="logo-sub">Admin</div>
            </div>
        </div>

        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Products
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="{{ request()->is('admin/customers*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Customers
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="bi bi-bag"></i>
                Orders
            </a>

        </nav>

    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="bi bi-box-arrow-left"></i>
            Log Out
        </button>
    </form>

</div>

{{-- GLOBAL TOPBAR --}}
<div class="global-topbar">

    <div class="dash-topbar-right">
        <button class="icon-btn"><i class="bi bi-bell"></i></button>
        <button class="icon-btn"><i class="bi bi-gear"></i></button>
        <button class="logo-btn" disabled><img src="{{ asset('images/butterbake.png') }}" alt="Butter Bake"></button>
    </div>
</div>