<div class="card mt-3">
    <div class="card-header">
        <h2><strong>{{$heading}}</strong></h2>
    </div>
    <div class="card-body">
        <div  class="only-bottom-border mb-3">
            <p>Filters</p>
            <div id="{{$datatableId}}-search" class="row">
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

@push('inner-script')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            const json = '{!! $datatableFilters !!} ';
            const filters = JSON.parse(json);
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
