@php
$resourceMenus = [

    'employees' => [
        'name' => 'employees',
        'isActive' => function ($routeName) {
            //expense-categories.index
            return in_array($routeName, ['employee-payments.index', 'employees.create', 'employees.index']);
            // $routeName == 'expenses.create' || $routeName == 'expenses.index';
        },
        'routes' => [
            ['name' => 'Employees', 'route' => 'employees.index'],
            ['name' => 'Add Employee', 'route' => 'employees.create'],
            ['name' => 'Employee Payments', 'route' => 'employee-payments.index']
        ],
    ],
    'masters',
    'suppliers',
    'customers',
    //'categories',
    //'products',
    'products' => [
        'name' => 'products',
        'isActive' => function ($routeName) {
            //expense-categories.index
            return in_array($routeName, ['products.index', 'products.create', 'categories.index','categories.create']);
            // $routeName == 'expenses.create' || $routeName == 'expenses.index';
        },
        'routes' => [
            ['name' => 'Products', 'route' => 'products.index'],
            ['name' => 'Add Products', 'route' => 'products.create'],
            ['name' => 'categories', 'route' => 'categories.index'],
            ['name' => 'add categories', 'route' => 'categories.create']
        ],
    ],
    'banks',
    'bank_accounts',
    'services',
    'orders',
    'sales',
    'purchases',
    'expense' => [
        'name' => 'Expense',
        'isActive' => function ($routeName) {
            //expense-categories.index
            return in_array($routeName, ['expense-categories.index', 'expenses.create', 'expenses.index']);
            // $routeName == 'expenses.create' || $routeName == 'expenses.index';
        },
        'routes' => [
            ['name' => 'Expenses', 'route' => 'expenses.index'],
            ['name' => 'Add Expense', 'route' => 'expenses.create'],
            ['name' => 'Expense Categories', 'route' => 'expense-categories.index']
        ],
    ],
];

$resourceRoutes = ['index', 'create'];
@endphp

<aside class="main-sidebar elevation-4">

    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="">
            <a href="{{ URL::to('') }}" class="  d-block nav-logo">
                <div class="logo b-block text-center">
                    <img src="{{ asset('asset/img/logo.jpeg') }}" class="" alt="User Image">
                </div>
            </a>
        </div>

        <hr class="mt-0">



        <!-- Sidebar Menu -->
        <nav class="">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}">
                        <i class="fas fa-list nav-icon"></i>
                        <p> Dashboard</p>
                    </a>
                </li>


                @foreach ($resourceMenus as $menu)
                    @if (is_string($menu))
                        <li
                            class="nav-item   {{ Route::current()->getName() == $menu . '.index' || Route::current()->getName() == $menu . '.create'
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#"
                                class="nav-link {{ Route::current()->getName() == $menu . '.index' || Route::current()->getName() == $menu . '.create'
                                    ? 'active'
                                    : '' }}">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>{{ Str::of($menu)->headline() }} <i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview ml-3" {!! Route::current()->getName() == $menu . '.index' || Route::current()->getName() == $menu . '.create' ? 'style="display: block;"' : '' !!}>
                                <li class="nav-item">
                                    <a href="{{ route($menu . '.index') }}"
                                        class="nav-link {{ Route::current()->getName() == $menu . '.index' ? 'active' : '' }}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p> {{ Str::of($menu)->headline() }} List</p>
                                    </a>

                                    <a href="{{ route($menu . '.create') }}"
                                        class="nav-link {{ Route::current()->getName() == $menu . '.create' ? 'active' : '' }}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p> Add {{ Str::of($menu)->headline() }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li
                            class="nav-item {{ $menu['isActive'](Route::current()->getName()) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ $menu['isActive'](Route::current()->getName()) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>{{ Str::of($menu['name'])->headline() }} <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" {!! $menu['isActive'](Route::current()->getName()) ? 'style="display: block;"' : '' !!}>
                                <li class="nav-item">
                                    @foreach ($menu['routes'] as $route)
                                        <a href="{{ route($route['route']) }}"
                                            class="nav-link {{ Route::current()->getName() == $route['route'] ? 'active' : '' }}">
                                            <i class="fas fa-list nav-icon"></i>
                                            <p> {{ Str::of($route['name'])->headline() }}</p>
                                        </a>
                                    @endforeach

                                </li>
                            </ul>
                        </li>
                    @endif
                @endforeach






                <!-- End Customer  -->


                <!-- Start Setting -->

                <li class="nav-item d-none">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>
                            Profile
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="profile.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="change_logo.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Logo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Fav</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- End Setting  -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
