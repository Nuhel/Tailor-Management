@extends('layout.layout')
@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
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
                        <form method="POST" action="{{ route('employee-payments.store') }}">


                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments',[
                                    "bankType"=>old('bank_type'),
                                    "bankId"=>old('bank_id'),
                                    "accountId"=>old('account_id'),
                                    ])
                                </div>
                            </div>
                            @csrf

                            {!! Form::select()->setLabel('Service')->appendInputClass('service-select')->setName('order_service_id')->setPlaceHolder('Select Payable Service')->setValue()->setOptions($orderServices)
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
    ->render() !!}

                            {!! Form::input()->setName('date')->setValue(old('date', now()->format('Y-m-d')))->setType('date') !!}
                            {!! Form::input()->setName('amount')->setValue()->setLabel()->setPlaceholder()->setType('number')->render() !!}
                            {!! Form::textarea()->setName('description')->setValue()->setLabel()->setPlaceholder()->render() !!}


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
    <script src="{{ asset('js/select2.js') }}"></script>
    @livewireScripts
    <script>
        function formatService(serviceOption) {
            try {
                data = JSON.parse(serviceOption.text);
                return $(
                    `<span>${data.name} Inv: ${data.inv} Service: ${data.service} Due: <span class='text-${data.due >0 ?'danger':''}'>${data.due}</span></span>`
                )
            } catch (e) {
                return serviceOption.text;
            };
        }
        $('.service-select').select2({
            templateResult: formatService,
            templateSelection: formatService
        });
    </script>
@endsection
