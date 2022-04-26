@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">

                <form action="" id="stock-form">
                    @include('components.datatable.base',['heading' => 'Manage Stock'])
                    <div>
                        <button type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@section('css')
    @stack('inner-css')
@endsection


@section('script')
        <script src="{{asset('js/axios.js')}}"></script>
        <script>

            var submittedFromSearch = false;
            $(document).on('change , keyup, keydown', '#product-table-search input', function(event){
                if(event.which == 13) {
                    submittedFromSearch = true;
                }
            })


            $('#stock-form').on('submit', function(event){
                event.preventDefault();
                if(submittedFromSearch){
                    submittedFromSearch = false;
                    return;
                }

                var data = $('#stock-form').serializeArray();
                var bodyFormData = new FormData();
                bodyFormData.append('_token', '{{ csrf_token() }}');
                var data = $('#stock-form').serializeArray().reduce(function(obj, item) {
                    bodyFormData.append(item.name, item.value);
                    obj[item.name] = item.value;
                    return obj;
                }, {});

            var url = "{{URL::to('/manage-stock')}}";
            axios({
                method: "post",
                url: url,
                data: bodyFormData,
            })
            .then(function (response) {
                $('.error.validation-error').remove();
                $('input').removeClass('is-invalid');
                Swal.fire(
                    'Success!',
                    'Stock Updated Successfully',
                    'success'
                )

            })
            .catch(function (error) {
                //console.log(error);
                if(error.response.status == 422){
                    $.each(error.response.data, function(index,val){
                        index = index.replace('.','-').replace('stock','').replace('.','');

                        $('#'+index).find('.error.validation-error').remove();

                        $('#'+index).append(`
                            <span class='text-danger error validation-error invalid-feedback' role="alert">`+val[0]+`</span>
                        `)
                        $('#'+index).find('input').addClass('is-invalid');
                    })
                }


                Swal.fire(
                    'Opps...!',
                    'Failed To Updated Stock',
                    'error'
                )
            });

            });

        </script>

    @stack('inner-script')
@endsection
