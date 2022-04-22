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
                                            <td>Customer Name</td>
                                            <td>{{$order->customer->name}}</td>
                                        </tr>

                                        <tr>
                                            <td>Sale Date</td>
                                            <td>{{$order->order_date}}</td>
                                        </tr>

                                        <tr>
                                            <td>Total Products</td>
                                            <td>{{$order->products->count()??"No Product Used"}}</td>
                                        </tr>

                                        @if ($order->discount > 0 )
                                            <tr>
                                                <td>Net Total</td>
                                                <td>{{$order->total}}</td>
                                            </tr>

                                            <tr>
                                                <td>Discount</td>
                                                <td>{{$order->discount}}</td>
                                            </tr>
                                        @endif


                                        <tr>
                                            <td>Total Payable</td>
                                            <td>{{$order->netpayable}}</td>
                                        </tr>

                                        <tr>
                                            <td>Paid</td>
                                            <td>{{$order->paid}}</td>
                                        </tr>

                                        <tr>
                                            <td>Due</td>
                                            <td>{{$order->netpayable - $order->paid}}</td>
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
                                @if ($order->products->count())
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
                                            @foreach ($order->products as $product)
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


