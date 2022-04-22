@push('inner-css')
    <link rel="stylesheet" type="text/css" href="{{asset('/vendor/datatables/css/datatable.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/vendor/datatables/css/datatable-extended.css')}}"/>
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
                var filter = filters[column.index()]
                if(filter !== undefined){
                    //console.log(typeof filter);
                    if(typeof filter === 'string' ){
                        var input = $('<input/>', {
                            class: 'w-100 form-control form-control-sm rounded',
                            placeholder: filter
                        }).on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        }).wrap('<div>').parent().addClass('form-group')
                        .wrap('<div>').parent().addClass('col-sm-12 col-md')
                        .appendTo($('#{{$datatableId}}-search'));
                    }else if(typeof filter === 'object'){
                        console.log(filter.name);
                        console.log(filter.type);
                    }

                }

            });
            $('#{{$datatableId}}_filter').remove();
            $('#{{$datatableId}}-reset-button').click(function(){
                $('#{{$datatableId}}-search').find('input').val('');
            });


        });
    </script>
@endpush
