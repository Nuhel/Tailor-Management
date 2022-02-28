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

@push('inner-css')
    <link rel="stylesheet" href="{{ asset('css/icheck.css') }}">
@endpush

@push('inner-script')

    {!! $dataTable->scripts() !!}
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var datatableIds = {!!collect($tableIds)->toJson()!!};
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

            $(document).on('change','.ready-checkbox', function(event){
                var baseUrl = "{{URL::to('/productions/make-ready/')}}";
                var checkBoxRef = $(this);
                var id = checkBoxRef.data('id');
                var url = baseUrl+'/'+id
                var bodyFormData = new FormData();
                bodyFormData.append('_token', '{{ csrf_token() }}');
                bodyFormData.append('ready', $(this).is(":checked"));

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approved As Ready!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        makeReady(url,bodyFormData,checkBoxRef)
                    }else{
                        checkBoxRef.prop("checked", false);
                    }
                })


            })
        });

        function makeReady(url,bodyFormData,checkBoxRef){
            axios({
                    method: "post",
                    url: url,
                    data: bodyFormData,
                })
                .then(function (response) {
                    console.log(response);
                    if(datatableIds != null){
                        $.each(datatableIds, function(index,datatableId){
                            var datatable = $('#{{$datatableId}}').dataTable();
                            datatable.api().ajax.reload();
                        })
                    }
                })
                .catch(function (error) {
                    checkBoxRef.prop("checked", false);
                    console.log(error);
                    return;
                });
        }
    </script>
@endpush
