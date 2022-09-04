<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tailor Management</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.css')}}">
  {{-- <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{ asset('css/css.css') }}">


    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link href="{{ asset('css/sweet-alert-bs.css') }}" rel="stylesheet">
  @yield('css')



</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
        @include('layout.header')
        @include('layout.sidebar')
        @yield('content')



    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-{{date('Y')}} <a href="https://syed-nuhel.com/">Syed Nuhel</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0-rc
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        Controll Sidebar
    </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  @include('layout.footer')

@yield('script')

</body>

</html>
