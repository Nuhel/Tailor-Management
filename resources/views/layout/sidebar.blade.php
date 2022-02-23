@php
    $resourceMenus = [
        'employees',
        'masters',
        'customers',
        'categories',
        'products',
        'banks',
        'bank_accounts',
        'services',
        'orders',
    ];

    $resourceRoutes = [
        'index',
        'create',
    ];
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">

 <!-- Brand Logo -->
 <!-- <a href="index.php" class="brand-link">
  <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">WM</span>
</a> -->


<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="">
    <a href="{{URL::to('')}}" class="  d-block nav-logo">
        <div class="logo b-block text-center">
            <img src="{{asset('asset/img/logo.jpeg')}}"  class="" alt="User Image">
        </div>

    </a>
  </div>

  <hr class="mt-0">



  <!-- Sidebar Menu -->
  <nav class="">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->



           @foreach ($resourceMenus as $menu)
            <li class="nav-item   {{ (
                Route::current()->getName() == $menu.'.index' ||
                Route::current()->getName() == $menu.'.create'
                )? "menu-is-opening menu-open":"" }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>{{Str::of($menu)->headline()}} <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview ml-3"
                    {!!
                        (Route::current()->getName() == $menu.'.index' ||
                        Route::current()->getName() == $menu.'.create'
                        )? 'style="display: block;"':""
                    !!}
                >
                    <li class="nav-item">
                        <a href="{{route($menu.'.index')}}" class="nav-link {{Route::current()->getName() == $menu.'.index'?"active":""}}">
                            <i class="fas fa-list nav-icon"></i>
                            <p> {{Str::of($menu)->headline()}} List</p>
                        </a>

                        <a href="{{route($menu.'.create')}}" class="nav-link {{Route::current()->getName() == $menu.'.create'?"active":""}}">
                            <i class="fas fa-plus nav-icon"></i>
                            <p> Add {{Str::of($menu)->headline()}}</p>
                        </a>
                    </li>
                </ul>
            </li>
           @endforeach






          <!-- End Customer  -->


          <!-- Start Setting -->

          <li class="nav-item">
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
