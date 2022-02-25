@push('inner-css')

    <link rel="stylesheet" type="text/css" href="{{asset('/vendor/datatables/css/datatable.css')}}"/>
    <style>
        .spacer{
            flex-basis: calc(100% - 268px) !important;
            background: transparent;
            border: none;
        }
        .spacer:hover,.spacer:active,.spacer:focus{
            background: transparent;
            pointer-events: none;
            border: none;
            box-shadow: none
        }
        .dt-buttons.btn-group.flex-wrap{
            width: 100%;
        }
    </style>
@endpush

<div class="card mt-3">
    <div class="card-header">
        <h2><strong>{{$heading}}</strong></h2>
    </div>
    <div class="card-body">
        <div  class="only-bottom-border mb-3">
            <p>Filters</p>
            <div id="{{$datatableId}}-search" class="row">
            </div>
        </div>
        {!! $dataTable->table() !!}
    </div>
</div>






@push('inner-script')



    <script src="{{asset('/vendor/datatables/datatable.js')}}"></script>
    <script src="{{asset('/vendor/datatables/buttons.js')}}"></script>
    <script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script>



    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            const json = '{!! $datatableFilters !!} ';
            const filters = JSON.parse(json);

            //var dataTable = $('#{{$datatableId}}').dataTable();

            var columns = $('#{{$datatableId}}').dataTable().api().columns();
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
                    .appendTo($('#{{$datatableId}}-search'));
                }

            });
            $('#{{$datatableId}}_filter').remove();
            $('#{{$datatableId}}-reset-button').click(function(){
                $('#{{$datatableId}}-search').find('input').val('');
            });


        });
    </script>
@endpush
