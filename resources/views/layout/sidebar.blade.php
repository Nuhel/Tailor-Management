
<!-- Main Sidebar Container -->
<aside class="main-sidebar  elevation-4">

 <!-- Brand Logo -->
 <!-- <a href="index.php" class="brand-link">
  <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">WM</span>
</a> -->


<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="">
    <a href="{{URL::to('')}}" class="  d-block nav-btn py-3 px-4">
        <div class="logo b-block text-center">
            <img src="{{asset('asset/img/logo.jpeg')}}"  class="img-circle rounded w-75 img-fluid" alt="User Image">
        </div>

    </a>
  </div>

  <hr class="mt-0">



  <!-- Sidebar Menu -->
  <nav class="">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->


           <!--------   Order --------->


           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('orders.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> New Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee_position.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Report Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee_shift.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Return</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee_shift.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Return Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Order Return Deliver Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Deliver Report</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- End Order  -->

          <!-- Start Employee -->

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Employee
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('employees.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Employee List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('employees.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Employee</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('masters.index')}}"  class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- End Employee  -->


          <!-- Start Customer -->

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Customer
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('customers.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('customers.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer List</p>
                </a>
              </li>

            </ul>
          </li>

          <!-- End Customer  -->

          <!-- Start Bank -->

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Bank
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('banks.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banks</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('banks.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Bank</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('bank_accounts.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bank Account List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('bank_accounts.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Bank Account</p>
                </a>
              </li>

            </ul>
          </li>
          <!-- End Bank  -->

          <!-- Start Customer -->

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Product
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('products.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('categories.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
            </ul>
          </li>

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
