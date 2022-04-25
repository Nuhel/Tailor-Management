@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                @include('components.datatable.base',['heading' => 'Purchases'])
            </div>
        </div>
    </div>
    @include('purchase.give-payment-modal',['datatableId'=> $datatableId])
@endsection




@section('css')
    @livewireStyles
    @stack('inner-css')
@endsection

@section('script')
    @stack('inner-script')
    @livewireScripts
@endsection
