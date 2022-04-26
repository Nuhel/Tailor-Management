@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h5>Today's Service</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Service: </span>
                                        <span>{{$serviceData->total}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>NetPayable: </span>
                                        <span>{{$serviceData->netpayable}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Total Paid: </span>
                                        <span>{{$serviceData->paid}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <h5>Today's Sale</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Sale: </span>
                                        <span>{{$saleData->total}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>NetPayable: </span>
                                        <span>{{$saleData->netpayable}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Total Paid: </span>
                                        <span>{{$saleData->paid}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h5>Today's Purchase</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Purchase: </span>
                                        <span>{{$purchaseData->total}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Payable: </span>
                                        <span>{{$purchaseData->netpayable}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span>Total Paid: </span>
                                        <span>{{$purchaseData->paid}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


