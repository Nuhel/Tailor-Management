@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-header">
                                <p class="mb-0">Basic Order Details</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Supplier Name</td>
                                            <td>{{$purchase->supplier->name}}</td>
                                        </tr>

                                        <tr>
                                            <td>Purchase Date</td>
                                            <td>{{$purchase->purchase_date}}</td>
                                        </tr>

                                        <tr>
                                            <td>Total Products</td>
                                            <td>{{$purchase->products->count()??"No Product Used"}}</td>
                                        </tr>

                                        @if ($purchase->discount > 0 )
                                            <tr>
                                                <td>Net Total</td>
                                                <td>{{$purchase->total}}</td>
                                            </tr>

                                            <tr>
                                                <td>Discount</td>
                                                <td>{{$purchase->discount}}</td>
                                            </tr>
                                        @endif


                                        <tr>
                                            <td>Total Payable</td>
                                            <td>{{$purchase->netpayable}}</td>
                                        </tr>

                                        <tr>
                                            <td>Paid</td>
                                            <td>{{$purchase->paid}}</td>
                                        </tr>

                                        <tr>
                                            <td>Due</td>
                                            <td>{{$purchase->netpayable - $purchase->paid}}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-header">
                                <p class="mb-0">Product Details</p>
                            </div>
                            <div class="card-body">
                                @if ($purchase->products->count())
                                    @php
                                        $totalPrice = 0;
                                        $totalQuantity = 0;
                                    @endphp
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase->products as $product)
                                                @php
                                                    $totalPrice += $product->price * $product->quantity;
                                                    $totalQuantity +=  $product->quantity;
                                                @endphp
                                                <tr>
                                                    <td>{{$product->product->name}}</td>
                                                    <td>{{$product->price}}</td>
                                                    <td>{{$product->quantity}}</td>
                                                    <td>{{$product->price * $product->quantity}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-right" colspan="2">Total's: </td>
                                                <td><p><strong>{{$totalQuantity}}</strong></p></td>
                                                <td><p><strong>{{$totalPrice}}</strong></p></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>No Product Used</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


