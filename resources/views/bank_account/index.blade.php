@extends('layout.layout')

@section('css')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.6.0/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.css"/>



@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Bank Account List</strong></h2>
                    </div>
                    <div class="card-body">

                        <div  class="only-bottom-border mb-3">
                            <p>Filters</p>
                            <div id="search" class="row">

                            </div>
                        </div>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>

{!! $dataTable->scripts() !!}



<script>
    $(document).ready(function() {

        var filters = {
            1:"Name",
            2:"Number",
            3:"Card",
        };
        var columns = $('#bankaccountdatatable').dataTable().api().columns();
        columns.every(function () {
            var column = this;

            if(filters[column.index()] !== undefined){
                var input = $('<input/>', {
                    class: 'w-100 form-control form-control-sm rounded',
                    placeholder: filters[column.index()]
                }).on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                }).wrap('<div>').parent().addClass('form-group')
                .wrap('<div>').parent().addClass('col-sm-12 col-md')
                .appendTo($('#search'));
            }

        });
    });

</script>

@endsection
