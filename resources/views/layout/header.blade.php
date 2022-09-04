<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex flex-column flex-sm-row align-items-start">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-lg-inline-block">
            <a href="{{ route('orders.index') }}" class="nav-link">Orders</a>
        </li>
        <li class="nav-item d-none d-lg-inline-block">
            <a href="{{ route('sales.index') }}" class="nav-link">Sales</a>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <a href="{{ route('productions.index') }}" class="nav-link">Productions</a>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <a href="{{ route('transactions.index') }}" class="nav-link">Transactions</a>
        </li>

        <li class="nav-item dropdown d-lg-none">
            <a class="nav-link btn" data-toggle="dropdown" aria-expanded="false">
                Quick Link
                <i class="fa-solid fa-angle-down dropdown-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('orders.index') }}" class="dropdown-item">
                    <small>Orders</small>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('sales.index') }}" class="dropdown-item">
                    <small>Sales</small>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('productions.index') }}" class="dropdown-item">
                    <small>Productions</small>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('transactions.index') }}" class="dropdown-item">
                    <small>Transactions</small>
                </a>
                <div class="dropdown-divider"></div>

            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link btn" data-toggle="dropdown" aria-expanded="false">
                Reports
                <i class="fa-solid fa-angle-down dropdown-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('order-report') }}" class="dropdown-item">
                    <small>Order Report</small>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('sale-report') }}" class="dropdown-item">
                    <small>Sale Report</small>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('purchase-report') }}" class="dropdown-item">
                    <small>Purchase Report</small>
                </a>
                <div class="dropdown-divider"></div>

            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item d-none">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <!-- Notifications Dropdown Menu -->
        <x-order-notification />


        <li class="nav-item d-none">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-link btn">Logout</button>
            </form>

        </li>
    </ul>
</nav>
<!-- /.navbar -->
