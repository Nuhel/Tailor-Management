<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tailor Management</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->


  <!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.js')}}"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper d-flex vh-100 flex-column">

    <div class="flex-grow-1">
        @yield('content')
    </div>

    <footer class="main-footer ml-0">
        <strong>Copyright &copy; 2014-2021 <a href="https://top-man.com">top-man.com</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0-rc
        </div>
    </footer>
  </div>
  <!-- ./wrapper -->


</body>

</html>
