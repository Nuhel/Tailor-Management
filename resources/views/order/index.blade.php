@extends('layout.layout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/datatables/css/datatable.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/datatables/css/datatable-extended.css') }}" />
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Orders</strong></h2>
                    </div>
                    <div class="card-body">
                        <div class="only-bottom-border mb-3">
                            <p>Filters</p>
                            <div id="{{ $datatableId }}-search" class="row">

                                <div class="col-sm-12 col-md">


                                    <div class="form-group">
                                        <input type="date" class="w-100 form-control form-control-sm rounded from"
                                            placeholder="From Date">
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md">


                                    <div class="form-group">
                                        <input type="date" class="w-100 form-control form-control-sm rounded to"
                                            placeholder="To Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('order.take-payment-modal', ['datatableId' => $datatableId])
@endsection









@section('script')
    <script src="{{ asset('/vendor/datatables/datatable.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/buttons.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>



    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            const json = '{!! $datatableFilters !!} ';
            const filters = JSON.parse(json);

            var orderDataTable = $('#{{ $datatableId }}').dataTable().api();

            var columns = $('#{{ $datatableId }}').dataTable().api().columns();
            columns.every(function() {
                var column = this;
                var filter = filters[column.index()]
                if (filter !== undefined) {
                    //console.log(typeof filter);
                    if (typeof filter === 'string') {
                        var input = $('<input/>', {
                                class: 'w-100 form-control form-control-sm rounded',
                                placeholder: filter
                            }).on('change', function() {
                                column.search($(this).val(), false, false, true).draw();
                            }).wrap('<div>').parent().addClass('form-group')
                            .wrap('<div>').parent().addClass('col-sm-12 col-md')
                            .appendTo($('#{{ $datatableId }}-search'));
                    } else if (typeof filter === 'object') {

                        var input = $('<input/>', {
                                class: 'w-100 form-control form-control-sm rounded',
                                placeholder: filter.name,
                                type: filter.type
                            }).on('change', function() {
                                column.search($(this).val(), false, false, true).draw();
                            }).wrap('<div>').parent().addClass('form-group')
                            .wrap('<div>').parent().addClass('col-sm-12 col-md')
                            .appendTo($('#{{ $datatableId }}-search'));


                    }

                }

            });
            $('#{{ $datatableId }}_filter').remove();
            $('#{{ $datatableId }}-reset-button').click(function() {
                $('#{{ $datatableId }}-search').find('input').val('');
            });
            $(".from").on('keyup change',function() {
                orderDataTable.draw();
            });

            $(".to").on('keyup change',function() {
                orderDataTable.draw();
            });



        });
    </script>
@endsection
