@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                @include('components.datatable.base',['heading' => 'Sales'])
            </div>
        </div>
    </div>
    @include('order.take-payment-modal',['datatableId'=> $datatableId])
@endsection




@section('css')
    @stack('inner-css')
    @livewireStyles
@endsection

@section('script')
    @livewireScripts
    @stack('inner-script')
@endsection
