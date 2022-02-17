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
                                            <td>Master Name</td>
                                            <td>{{$order->master->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Trial Date</td>
                                            <td>{{$order->trial_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delivary Date</td>
                                            <td>{{$order->delivery_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Service</td>
                                            <td>{{$order->services->count()}}</td>
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
                                            <td>{{$order->due}}</td>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="mb-0">Services</p>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    @foreach ($order->services as $service)
                                        <div class="col-md-6">
                                            <div class="p-2 border rounded mb-2 position-relative">
                                                <span class="badge badge-danger position-absolute top-_5px left-_5px rounded circle">
                                                    {{$loop->iteration}}
                                                </span>
                                                <p class="text-center">
                                                    {{$service->service->name}}
                                                </p>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$service->quantity}}</td>
                                                            <td>{{$service->price}}</td>
                                                            <td>{{$service->quantity * $service->price}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div>
                                                    <p class="mb-1">Measurement's</p>
                                                    @foreach ($service->serviceMeasurements as $measurement)
                                                        <span class="badge badge-pill badge-info">
                                                            {{Str::of($measurement->measurement->name)->headLine()}} : {{$measurement->size}}
                                                        </span>
                                                    @endforeach
                                                </div>


                                                <div>
                                                    <p class="mb-1">Design's</p>
                                                    @foreach ($service->serviceDesigns as $design)
                                                        <span class="badge badge-pill badge-info">
                                                            {{Str::of($design->design!=null ? $design->design->name: $design->design_name)->headLine()}} : {{$design->style!=null?$design->style->name:$design->style_name}}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


