<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <style>


    </style>

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <title>Topman {{$order->invoice_no}}</title>


  </head>

  @php
      $spacer = '40px';
  @endphp
  <body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding" id="printable">


        <div class="">
            <hr style="border-color: red;border-top-width: 5px; margin-bottom:{{$spacer}}">

            <table style="width: 100%">
                <tr>
                    <td style="width: 60%">
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 30%;text-align: center;padding-right: 40px;">
                                    <img src="{{asset('asset/img/logo.jpeg')}}"  class="" alt="User Image" style="width: 100%; height: 100px">
                                </td>
                                <td style="width: 49%">
                                    <h3>Top Man</h3>
                                    <p>Phone: 0162363636</p>
                                    <span>Address: Saifur Rahman Road, Moulvibazar, Moulvibazar Sadar. Email: topman.bd@gmail.com</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 40%; text-align:right">
                        <span>Invoice No:</span><br>
                        <span>{{$order->invoice_no}}</span><br>
                        <span>Date:</span><br>
                        <span>{{$order->order_date}}</span><br>
                    </td>
                </tr>
            </table>
            <hr class="" style="border-color: #dee2e6;border-top-width: 2px;margin-top:{{$spacer}}; margin-bottom:5px ">
            <div class="card-body pt-0" >
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h3 class="text-dark mb-1">Customer Info</h3>
                        <h5 class="text-dark mb-1">{{$order->customer->name}}</h5>
                        @if ($order->customer->address)
                            <div>Address: {{$order->customer->address}}</div>
                        @endif
                        @if ($order->customer->email)
                            <div>Email: {{$order->customer->email}}</div>
                        @endif

                        @if ($order->customer->mobile)
                            <div>Phone: {{$order->customer->mobile}}</div>
                        @endif
                    </div>
                </div>

                <div style="margin-top: {{$spacer}}"></div>
                <div class="table-responsive-sm">
                    <div class="mt-5">
                        <p><strong>Services</strong></p>
                        <table class="table table-sm w-100">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="center">#</th>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;">Item</th>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;">Description</th>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="right">Price</th>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6; text-align:center" class="center">Qty</th>
                                    <th style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6; text-align:right" class="right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $serviceSubTotal = 0;
                                @endphp
                                @foreach ($order->services as $service)
                                    @php
                                        $serviceSubTotal += $service->quantity * $service->price;
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="center"><small>{{$loop->iteration}}</small></td>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="left strong"><small>{{$service->service->name}}</small></td>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="left">
                                            <small style="text-decoration: underline;">Measurments:</small><small>&nbsp;</small>
                                            @foreach ($service->serviceMeasurements as $measurement)
                                                <small class="">
                                                    {{Str::of($measurement->measurement->name)->headLine()}} : {{$measurement->size}}
                                                </small>
                                            @endforeach
                                            <br/>
                                            <small style="text-decoration: underline;">Designs:</small><small>&nbsp;</small>
                                            @foreach ($service->serviceDesigns as $design)
                                                <small class="">
                                                    {{Str::of($design->design!=null ? $design->design->name: $design->design_name)->headLine()}} : {{$design->style!=null?$design->style->name:$design->style_name}}
                                                </small>
                                            @endforeach
                                        </td>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="right"><small>{{$service->price}}</small></td>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6; text-align:center" class="center"><small>{{$service->quantity}}</small></td>
                                        <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6; text-align:right" class="right"><small>{{$service->quantity * $service->price}}</small></td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="6" style="text-align: right"><small><strong>Total: {{$serviceSubTotal}}</strong></small></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    @if ($order->products->count())
                        <div class="mt-5">
                            <p><strong>Products</strong></p>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Item</th>
                                        <th class="right">Price</th>
                                        <th style="text-align: center"class="center">Qty</th>
                                        <th style="text-align: right" class="right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $productSubTotal = 0;
                                    @endphp
                                    @foreach ($order->products as $product)
                                        @php
                                            $productSubTotal += $product->quantity * $product->price;
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="center"><small>{{$loop->iteration}}</small></td>
                                            <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="center"><small>{{$product->product->name}}</small></td>
                                            <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;" class="right"><small>{{$product->price}}</small></td>
                                            <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6;text-align: center " class="center"><small>{{$product->quantity}}</small></td>
                                            <td style="vertical-align: middle;border-bottom-width: 1px;border-bottom-style: solid;border-color: #dee2e6; text-align: right" class="right"><small>{{$product->quantity * $product->price}}</small></td>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="text-align: right"><small><strong>Total: {{$productSubTotal}}</strong></small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5" style="width: 50%">

                    </div>
                    <div class="col-lg-4 col-sm-5 ml-auto" style="width: 50%">
                        <table class="table table-clear">
                            <tbody>

                                @if ($order->discount > 0 )
                                    <tr>
                                        <td style="border-top: none;">Sub Total</td>
                                        <td style="border-top: none; text-align:right">{{$order->total}}</td>
                                    </tr>

                                    <tr>
                                        <td>Discount</td>
                                        <td style="text-align:right">{{$order->discount}}</td>
                                    </tr>

                                    <tr>
                                        <td>Net Total</td>
                                        <td style="text-align:right">{{$order->netpayable}}</td>
                                    </tr>

                                @else
                                    <tr>
                                        <td style="border-top: none;">Net Total</td>
                                        <td style="border-top: none; text-align:right">{{$order->netpayable}}</td>
                                    </tr>

                                @endif

                                <tr>
                                    <td>Paid</td>
                                    <td style="text-align:right">{{$order->paid}}</td>
                                </tr>

                                @if ($order->netpayable - $order->paid > 0 )
                                    <tr>
                                        <td>Due</td>
                                        <td style="text-align:right">{{$order->netpayable - $order->paid}}</td>
                                    </tr>
                                @endif



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="mt-2 text-right">
        <button class="btn btn-sm btn-primary" id="print">Print</button>
    </div>

        <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.js')}}"></script>
    <script src="{{asset('js/printThis.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script>
        $('#print').click(function(){
            $('#printable').printThis({
                importCSS: true,            // import parent page css
                importStyle: false,
                base: false
            });
        })
    </script>
</body>
</html>


