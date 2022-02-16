<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tailor Management</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/css.css') }}">
  <link rel="stylesheet" href="{{asset('css/jquery.timepicker.css')}}">
  <link rel="stylesheet" href="{{asset('css/jquery.timepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/employee.css')}}">
  @yield('css')

  <!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.js')}}"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

@include('layout.header')
@include('layout.sidebar')

        @yield('content')

@include('layout.footer')

@yield('script')

</body>

</html>
