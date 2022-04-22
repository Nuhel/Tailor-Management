@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Give Payment</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('employee-payments.store')}}">
                            @csrf

                            {!!
                                Form::select()
                                ->setLabel('Service')
                                ->setName('order_service_id')
                                ->setPlaceHolder('Select Payable Service')
                                ->setValue()
                                ->setOptions($orderServices)
                                ->setOptionBuilder(
                                    function($value) {
                                        $employeeName = $value->employee!=null?$value->employee->name:'Not Assigned';
                                        return [ $value->id,"(".$value->order->invoice_no.")".$value->service->name."(".$employeeName.")"."(Due".($value->crafting_price-($value->paid??0)).")"];
                                    }
                                )
                                ->render()
                            !!}

                            {!!Form::input()->setName('date')->setValue(old('date',now()->format('Y-m-d')))->setType('date')!!}
                            {!!Form::input()->setName('amount')->setValue()->setLabel()->setPlaceholder()->setType('number')->render()!!}
                            {!!Form::textarea()->setName('description')->setValue()->setLabel()->setPlaceholder()->render()!!}


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
