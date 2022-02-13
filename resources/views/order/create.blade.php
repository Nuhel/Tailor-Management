@extends('layout.layout')

@section('content')


    <div class="content-wrapper">
        <div class="content  pt-3">
            <div class="container-fluid">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="card">

                        @if($errors->any())
                            @php
                                dump( $errors->all())
                            @endphp
                        @endif

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-end">
                                        <div class="form-group d-flex w-auto flex-grow-1 flex-column mb-0">
                                            <label class="form-inline">Customer</label>
                                           <select name="customer_id" class="js-example-basic-single form-control form-control-sm" id="customer_id">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{$customer->id}}" {{$customer->id == old('customer_id')?"selected":""}}>{{$customer->name}} ({{$customer->mobile}})</option>
                                                @endforeach
                                           </select>
                                        </div>

                                        <a class="btn btn-sm btn-outline-success ml-1 " data-toggle="modal" data-target="#create-customer-modal">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    @error('customer_id')
                                        <span class="text-danger ">{{$message}}</span>
                                    @enderror

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-inline">Master Name</label>
                                        <select name="master_id" class="form-control form-control-sm" >
                                            <option value="">Select Master</option>
                                            @foreach ($masters as $master)
                                                <option value="{{ $master->id }}" {{$master->id == old('master_id')?"selected":""}}>{{ $master->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('master_id')
                                            <span class="text-danger ">{{$message}}</span>
                                        @enderror
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
                                    @livewire('order-product',[
                                        'oldSelectedProducts' => collect(old('products',[]))->pluck('id'),
                                        'oldProductQuantities' => collect(old('products',[]))->pluck('quantity'),
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments',[
                                        "bankType"=>old('bank_type'),
                                        "bankId"=>old('bank_id'),
                                        "accountId"=>old('account_id'),
                                    ])
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
    @include('order.create-customer-modal')

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

