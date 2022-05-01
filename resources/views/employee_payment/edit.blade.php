@extends('layout.layout')
@section('css')
    <link href="{{ asset('css/select2.css')}}" rel="stylesheet" />
    @livewireStyles
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Give Payment</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('employee-payments.update',['employee_payment'=>$employee_payment])}}">
                            @csrf
                            @method('PUT ')

                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments',[
                                        "bankType"=>old('bank_type', $bankType),
                                        "bankId"=>old('bank_id',$bankId),
                                        "accountId"=>old('account_id',$employee_payment->sourceable_id),
                                    ])
                                </div>
                            </div>

                            {!!
                                Form::select()
                                ->setLabel('Service')
                                ->setName('order_service_id')
                                ->appendInputClass('service-select')
                                ->setPlaceHolder('Select Payable Service')
                                ->setValue($employee_payment->transactionable_id)
                                ->setOptions($orderServices)
                                ->setOptionBuilder(
                                    function($value) {
                                        $employeeName = $value->employee!=null?$value->employee->name:'Not Assigned';
                                        return [
                                            $value->id,
                                           json_encode(
                                               [
                                                'name' => $employeeName,
                                                'inv' => $value->order->invoice_no,
                                                'service' => $value->service->name,
                                                'due' => ( $value->crafting_price-($value->paid??0))
                                               ]
                                           )
                                        ];
                                    }
                                )
                                ->render()
                            !!}

                            {!!Form::input()->setName('date')->setValue(old('date',Carbon::parse($employee_payment->transaction_date)->format('Y-m-d')))->setType('date')!!}
                            {!!Form::input()->setName('amount')->setValue($employee_payment->amount)->setLabel()->setPlaceholder()->setType('number')->render()!!}
                            {!!Form::textarea()->setName('description')->setValue($employee_payment->description)->setLabel()->setPlaceholder()->render()!!}


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
@section('script')
    <script src="{{ asset('js/select2.js')}}"></script>
    @livewireScripts
    <script>
                function formatService(serviceOption){
                    try {
                        data = JSON.parse(serviceOption.text);
                        return $(`<span>${data.name} Inv: ${data.inv} Service: ${data.service} Due: <span class='text-${data.due >0 ?'danger':''}'>${data.due}</span></span>`)
                    }
                    catch (e) {
                        return serviceOption.text;
                    };
                }
        $('.service-select').select2({
            templateResult: formatService,
            templateSelection: formatService
        });
    </script>
@endsection
