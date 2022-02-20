@extends('layout.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Bank List</strong></h2>
                    </div>
                    <div class="card-body">
                        @include('components.datatable.base',['id'=>'bankaccountdatatable'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('css')
    @stack('inner-css')
@endsection


@section('script')
    @stack('inner-script')
@endsection
