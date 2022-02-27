@extends('layout.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content pt-3">
            <div class="container-fluid">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="d-flex align-items-{{ $errors->has('customer_id')?"center":"end"}}">
                                        <div class="form-group d-flex w-auto flex-grow-1 flex-column mb-0">
                                            <label class="form-inline">Customer</label>
                                           <select name="customer_id" class="customer-select form-control form-control-sm @error('customer_id') is-invalid @enderror" id="customer_id">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{$customer->id}}" {{$customer->id == old('customer_id')?"selected":""}}>{{$customer->name}} ({{$customer->mobile}})</option>
                                                @endforeach
                                           </select>
                                           @error('customer_id')
                                                <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <a class="btn btn-sm btn-outline-success ml-1 " data-toggle="modal" data-target="#create-customer-modal">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                </div>

                                <div class="col-md-3">
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
                                <div class="col-md-6">
                                    <div class="row">

                                        <div class="col-md-4">
                                            {!!Form::input()->setName('order_date')->setValue(old('order_date',now()->format('Y-m-d')))->setType('date')!!}
                                        </div>

                                        <div class="col-md-4">
                                            {!!Form::input()->setName('trial_date')->setValue(old('trial_date', now()->addDays(3)->format('Y-m-d')))->setType('date')!!}
                                        </div>

                                        <div class="col-md-4">
                                            {!!Form::input()->setName('delivery_date')->setValue(old('delivery_date',now()->addDays(5)->format('Y-m-d')))->setType('date')!!}
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('order.service-reapeater.service-repeater', ['oldServices'=>old('services',[])])

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

                            <div class="card">
                                <div class="card-body">
                                    <p>Payments</p>
                                    <table class="table table-sm ">
                                        <tbody>
                                            <tr>
                                                <td class="w-20"><small>Total</small></td>
                                                <td>
                                                    <small class="mb-0 pl-2" id="total-show">0</small>
                                                    <input value="{{old('total',0)}}" name="total" type="hidden"  id="total-value" >
                                                    @error('total')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ><small>Discount</small></td>
                                                <td>
                                                    <input name="discount" value="{{old('discount',0)}}" type="number" class="form-control form-control-sm rounded only-bottom-border" id="discount-value">
                                                    @error('discount')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ><small>Net Payabel</small></td>
                                                <td>
                                                    <small class="mb-0 pl-2" id="netpayable-show">0</small>
                                                    <input value="{{old('netpayable',0)}}" name="netpayable" type="hidden" id="netpayable-value">
                                                    @error('netpayable')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <td ><small>Paid</small></td>
                                                <td>
                                                    <input name="paid" type="number" value="{{old('paid',0)}}" id="paid-value" class="form-control form-control-sm rounded only-bottom-border">
                                                    @error('paid')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><small>Due</small></td>
                                                <td>
                                                    <small class="mb-0 pl-2" id="due-show">0</small>
                                                    <input value="{{old('due',0)}}" name="due" type="hidden" id="due-value" class="form-control form-control-sm rounded only-bottom-border">
                                                    @error('due')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            $(document).on('keyup change', '.price, .quantity, #discount-value, #paid-value', function() {
                calculatePayments()
            });
            calculatePayments()

        });

        function calculatePayments(){
            var services = $('.service-repeater .repeater-item');
                var totalServicePrice = 0;
                $.each(services, function(index,service){
                    //var price = $(this).find('.price').val();
                    var price = parseFloat($(this).find('.price').val())||0;
                    var quantity = parseFloat($(this).find('.quantity').val())||0;
                    totalServicePrice += price*quantity;

                });

                var cartProducts = $('.cart-product');
                var cartProductPrice = 0;
                $.each(cartProducts, function(index,service){
                    //var price = $(this).find('.price').val();
                    var price = parseFloat($(this).find('.price').val())||0;
                    var quantity = parseFloat($(this).find('.quantity').val())||0;
                    cartProductPrice += price*quantity;

                });

                var totalPrice = totalServicePrice + cartProductPrice
                var discount = parseFloat($('#discount-value').val())||0;


                $('#total-show').text(totalPrice);
                $('#total-value').val(totalPrice);

                var netPayable = totalPrice-discount;

                $('#netpayable-show').text(netPayable);
                $('#netpayable-value').val(netPayable);

                var paid = parseFloat($('#paid-value').val())||0;
                $('#due-show').text(netPayable-paid);
                $('#due-value').val(netPayable-paid);

        }
    </script>
@endsection

