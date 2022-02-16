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
                                <div class="col-md-4">
                                    <div class="d-flex align-items-end">
                                        <div class="form-group d-flex w-auto flex-grow-1 flex-column mb-0">
                                            <label class="form-inline">Customer</label>
                                           <select name="customer_id" class="customer-select form-control form-control-sm" id="customer_id">
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

                                <div class="col-md-4">
                                    {!!
                                        Form::select()
                                        ->setName('master_id')
                                        ->setLabel('Master')
                                        ->setPlaceholder('Select Master')
                                        ->setValue(old('master_id'))
                                        ->setOptions($masters)
                                        ->setOptionBuilder(function($value){
                                            return [$value->id, $value->name];
                                        })
                                    !!}
                                </div>
                                <div class="col-md-4">
                                    {!!Form::input()->setName('delivery_date')->setValue(old('delivery_date'))->setType('date')!!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('order.service-reapeater.service-repeater')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-product',[
                                        'oldCart' => collect(old('products',[]))
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
    @livewireScripts
    @stack('inner-script')
    <script>

        $(document).ready(function() {
            $('.customer-select').select2();
            $(document).on('keyup change', '.price, .quantity', function() {
                console.log("called");
            });

        });
    </script>
@endsection

