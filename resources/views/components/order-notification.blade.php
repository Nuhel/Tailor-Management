<!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link btn" data-toggle="dropdown">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge">{{$notifications->count()}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">{{$notifications->count()}} Pending Orders</span>
      <div class="dropdown-divider"></div>
        @foreach ($notifications as $order)
        <a href="{{route('orders.show', ['order' => $order])}}" class="dropdown-item">
            <small><i class="fas fa-clock mr-2"></i>({{$order->invoice_no}}) {{$order->delivery_date}}</small>
        </a>
        <div class="dropdown-divider"></div>
      @endforeach

    </div>
  </li>
