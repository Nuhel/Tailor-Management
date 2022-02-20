@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                @include('components.datatable.base',['heading' => 'Products'])

            </div>
        </div>
    </div>

    @include('product.add-modal',['categories'=>$categories])
@endsection



@section('css')
    @stack('inner-css')
@endsection


@section('script')
    @if (Session::has('action') && Session::get('action') == 'modal-open')
        <script>
            $('#product-add-modal').modal('show');
        </script>
    @endif
    @stack('inner-script')
@endsection
