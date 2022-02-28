<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->

<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<script src="{{ asset('js/sweet-alert.js')}}"></script>

@if (Session::has('alert'))
    <script>
        Swal.fire({
            icon: '{{Session::get('alert')['status']}}',
            title: '{{Session::get('alert')['title']}}',
            text: '{{Session::get('alert')['text']}}',
        })
    </script>
@endif
