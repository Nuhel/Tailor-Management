@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-3">
            <div class="container-fluid">
                <form method="POST" action="{{ route('purchases.update',['purchase'=>$purchase]) }}">
                    @method('put')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="d-flex align-items-{{ $errors->has('supplier_id')?"center":"end"}}">
                                        <div class="form-group d-flex w-auto flex-grow-1 flex-column mb-0">
                                            <label class="form-inline">Supplier</label>
                                           <select name="supplier_id" class="customer-select form-control form-control-sm @error('supplier_id') is-invalid @enderror" id="customer_id">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" {{$supplier->id == old('supplier_id',$purchase->supplier_id)?"selected":""}}>{{$supplier->name}} ({{$supplier->mobile}})</option>
                                                @endforeach
                                           </select>
                                           @error('supplier_id')
                                                <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <a class="btn btn-sm btn-outline-success ml-1 " data-toggle="modal" data-target="#create-supplier-modal">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                </div>



                                <div class="col-md-6">
                                    {!!Form::input()->setName('purchase_date')->setValue(old('purchase_date',$purchase->purchase_date))->setType('date')!!}
                                </div>


                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">

                                    @livewire('purchase-product',[
                                        'oldCart' => collect(old('products',$purchase->products)),
                                        'onEdit' => true
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-body">
                                    <p>Payments</p>
                                    <table class="table table-sm ">
                                        <tbody>
                                            <tr>
                                                <td class="w-20"><small>Total</small></td>
                                                <td>
                                                    <small class="mb-0 pl-2" id="total-show">{{old('total',$purchase->total)}}</small>
                                                    <input value="{{old('total',$purchase->total)}}" name="total" type="hidden"  id="total-value" >
                                                    @error('total')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ><small>Discount</small></td>
                                                <td>
                                                    <input name="discount" value="{{old('discount',$purchase->discount)}}" type="number" class="form-control form-control-sm rounded only-bottom-border" id="discount-value">
                                                    @error('discount')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ><small>Net Payabel</small></td>
                                                <td>
                                                    <small class="mb-0 pl-2" id="netpayable-show">{{old('netpayable',$purchase->netpayable)}}</small>
                                                    <input value="{{old('netpayable',$purchase->netpayable)}}" name="netpayable" type="hidden" id="netpayable-value">
                                                    @error('netpayable')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <td ><small>Paid</small></td>
                                                <td>
                                                    <input name="paid" type="number" value="{{old('paid',$purchase->paid)}}" id="paid-value" class="form-control form-control-sm rounded only-bottom-border">
                                                    @error('paid')
                                                        <span class="text-danger error validation-error d-block mb-2">{{$message}}</span>
                                                    @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><small>Due</small></td>
                                                <td>

                                                    <small class="mb-0 pl-2" id="due-show">{{old('due',($purchase->netpayable - $purchase->paid))}}</small>
                                                    <input value="{{old('due',($purchase->netpayable - $purchase->paid))}}" name="due" type="hidden" id="due-value" class="form-control form-control-sm rounded only-bottom-border">
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

