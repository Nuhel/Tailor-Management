@extends('layout.layout')




@section('content')
    <div class="content-wrapper">
        <div class="content  pt-3">
            <div class="container-fluid">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-inline">Customer Phone</label>
                                        <input class="form-control form-control-sm" type="text" name="phone"  placeholder="Enter Customer Phone" value="{{old('phone')}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-inline">Customer Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name"  placeholder="Enter Customer Name" value="{{old('name')}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-inline">Master Name</label>
                                        <select name="master_id" class="form-control form-control-sm" >
                                            <option value="" selected></option>
                                            @foreach ($masters as $master)
                                                <option value="{{ $master->id }}" {{$master->id == old('master_id')?"selected":""}}>{{ $master->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="repeater card">



                        <div data-repeater-list="services" class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-inline">Services's</label>
                                </div>
                            </div>

                            @forelse (old('services',[]) as $service)
                                @include('order.service-repeater-item', ['services' => $services,'oldService' => $service,'serviceIndex' => $loop->index])
                            @empty
                                @include('order.service-repeater-item', ['services' => $services,'oldService' => [], 'serviceIndex' => 0])
                            @endforelse

                        </div>


                        <div class="card-body pt-0">
                            <button href="" data-repeater-create class="btn btn-outline-success btn-sm" type="button">Add
                                Service</button>
                        </div>

                    </div>





                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-product')
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments')
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                            </div>
                        </div>
                    </div>





                </form>
            </div>
        </div>
    </div>

@endsection


@section('css')
@stack('inner-style')
    @livewireStyles
    <style>
        .service-remove-button{
            top: -15px;
            right: -10px;
        }
    </style>


@endsection

@section('script')
    @stack('inner-script')

    @livewireScripts
    <script src="{{ asset('js/repeater.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.repeater').repeater({

                repeaters: [{
                    // (Required)
                    // Specify the jQuery selector for this nested repeater
                    selector: '.inner-repeater'
                }],
                initEmpty: false,
                show: function() {
                    if ($(this).find('> .alert-message').length) {
                        $(this).find('> .alert-message').remove();
                    }
                    $(this).slideDown();
                    $($(this).find('.service_id')[0]).data('index',$('.service_id').length-1);
                    $('html, body').animate({
                        scrollTop: $($(this).find('.service_id')[0]).offset().top
                    }, 2000);

                    $($(this).find('.service_id')[0]).focus();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                ready: function(setIndexes) {
                    //$dragAndDrop.on('drop', setIndexes);
                },

                isFirstItemUndeletable: true
            })
        });
    </script>
    <script>
        const json = '{!! html_entity_decode($json) !!} ';
        const obj = JSON.parse(json);

        $(document).on('change', '.service_id', function($event) {
            var id = $(this).val();
            console.log($(this).data('index'));

            if (id != null && id!="") {
                var serviceIndex = $(this).data('index');
                var service = obj[id];
                if (service != undefined && service != null) {
                    var measurements = service['measurements'];
                    var measurementinputs = "<table class='table table-sm table-borderless'>";
                    $.each(measurements, function(index,value){
                        measurementinputs+=`
                            <tr class="">
                                <td><small>`+value['name']+`</small></td>
                                <td>
                                    <input type="text" name="services[`+serviceIndex+`][measurements][`+index+`][size]"
                                    class="form-control form-control-sm "
                                    placeholder="Size" value="" />

                                    <input type="hidden" name="services[`+serviceIndex+`][measurements][`+index+`][id]" value="`+value['id']+`" />
                                    <input type="hidden" name="services[`+serviceIndex+`][measurements][`+index+`][name]" value="`+value['name']+`" />
                                </td>

                            </tr>
                        `
                    });
                    measurementinputs+='</table>'

                    var row = $($(this).parents('.row')[0]);
                    var repeaterItem = $(row.parents('.repeater-item')[0]);
                    var measurementInput = $(repeaterItem.find('.measurement-inputs')[0]);
                    measurementInput.html(measurementinputs);


                    var designs = service['designs'];
                    var designInputs = "";

                    $.each(designs, function(index,value){

                        var styles = value['styles'];
                        var options = "";
                        $.each(styles, function(index,value){
                            options+='<option value="'+value['id']+'">'+value['name']+'</option>'
                        });

                        designInputs+=`
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small >`+value['name']+`</small>
                                    <select class="form-control form-control-sm" name="services[`+serviceIndex+`][designs][`+index+`][id]">`
                                        +options+
                                    `</select>
                                </div>
                            </div>
                        `
                    });
                    var designInput = $(repeaterItem.find('.design-inputs')[0]);
                    designInput.html(designInputs);
                }


            }else{
                var row = $($(this).parents('.row')[0]);
                var repeaterItem = $(row.parents('.repeater-item')[0]);
                var measurementInput = $(repeaterItem.find('.measurement-inputs')[0]);
                var designInput = $(repeaterItem.find('.design-inputs')[0]);
                measurementInput.empty();
                designInput.empty();
            }

        });

        //$('.service_id').trigger('change');


        $(document).on('click', '.measurement-show-btn', function(){
            var collapseable = $($(this).parent().parent().find('.collapse')[0]);

            if(collapseable.hasClass('show')){
                $(this).find('i').attr('class','fa fa-caret-down');
                collapseable.collapse('hide');
            }else{
                $(this).find('i').attr('class','fa fa-caret-up');
                collapseable.collapse('show');
            }
        });

    </script>
@endsection

