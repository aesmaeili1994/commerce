<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pr-0" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Brand Name</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span> داشبورد </span></a>
    </li>


    @role('admin')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            کاربران
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
               aria-expanded="true"
               aria-controls="collapsePages">
                <i class="fas fa-fw fa-users"></i>
                <span> کاربران </span>
            </a>
            <div id="collapseUsers" class="collapse
            {{ request()->is('admin-panel/management/users*') ? 'show' : '' }}
            {{ request()->is('admin-panel/management/roles*') ? 'show' : '' }}
            {{ request()->is('admin-panel/management/permissions*') ? 'show' : '' }} "
            aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('admin-panel/management/users*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">لیست کاربران</a>
                    <a class="collapse-item {{ request()->is('admin-panel/management/roles*') ? 'active' : '' }}"
                       href="{{ route('admin.roles.index') }}">نقش کاربران</a>
                    <a class="collapse-item {{ request()->is('admin-panel/management/permissions*') ? 'active' : '' }}"
                       href="{{ route('admin.permissions.index') }}">پرمیژن ها</a>
                </div>
            </div>
        </li>
    @endrole



<!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        فروشگاه
    </div>

    <!-- Nav Item - Brand -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.brands.index') }}">
            <i class="fas fa-store"></i>
            <span> برندها </span>
        </a>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
           aria-expanded="true"
           aria-controls="collapsePages">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span> محصولات </span>
        </a>
        <div id="collapseProducts" class="collapse
        {{ request()->is('admin-panel/management/products*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/categories*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/attributes*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/tags*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/comments*') ? 'show' : '' }} "
        aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin-panel/management/products*') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">محصولات</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/categories*') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">دسته بندی ها</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/attributes*') ? 'active' : '' }}"
                    href="{{ route('admin.attributes.index') }}">ویژگی ها</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/tags*') ? 'active' : '' }}"
                    href="{{ route('admin.tags.index') }}">برچسب ها</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/comments*') ? 'active' : '' }}"
                    href="{{ route('admin.comments.index') }}">کامنت ها</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        سفارشات
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="true"
           aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span> سفارشات </span>
        </a>
        <div id="collapseOrders" class="collapse
        {{ request()->is('admin-panel/management/orders*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/transactions*') ? 'show' : '' }}
        {{ request()->is('admin-panel/management/coupons*') ? 'show' : '' }} "
        aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin-panel/management/orders*') ? 'active' : '' }}"
                   href="{{ route('admin.orders.index') }}">سفارشات</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/transactions*') ? 'active' : '' }}"
                   href="{{ route('admin.transactions.index') }}">تراکنش ها</a>

                <a class="collapse-item {{ request()->is('admin-panel/management/coupons*') ? 'active' : '' }}"
                   href="{{ route('admin.coupons.index') }}">کوپن ها</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        تنظیملت
    </div>

    <!-- Nav Item - Banner -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.banners.index') }}">
            <i class="fas fa-image"></i>
            <span> بنرها </span>
        </a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
