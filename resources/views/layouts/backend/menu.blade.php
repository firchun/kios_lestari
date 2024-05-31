<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('backend_theme') }}/assets/img/favicon.ico" class="navbar-logo" alt="logo"
                        style="width: 39px; height:39px; object-fit:cover;">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{ url('/') }}" class="nav-link"> {{ env('APP_NAME') }} </a>
            </li>
            <li class="nav-item toggle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left sidebarCollapse">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </li>
        </ul>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Dashboard</span></div>
            </li>
            <li class="menu {{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ url('/home') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-home bx-sm" style="vertical-align: middle;"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Customer</span></div>
            </li>
            <li class="menu {{ request()->is('customers') ? 'active' : '' }}">
                <a href="{{ url('/customers') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                        <span>Customers</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Users</span></div>
            </li>
            <li class="menu {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ url('/users') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                        <span>Users</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Akun</span></div>
            </li>
            <li class="menu {{ request()->is('profile') ? 'active' : '' }}">
                <a href="{{ route('profile') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                        <span>Profile</span>
                    </div>
                </a>
            </li>

        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
