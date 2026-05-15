<div class="sidebar">

    <div>

        <div class="sidebar-logo">
            Butter Bake
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

            <a href="#"
               class="{{ request()->is('admin/customers*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Customers
            </a>

            <a href="#"
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