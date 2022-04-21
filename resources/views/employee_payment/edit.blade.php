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
                        <form method="POST" action="{{route('employee-payments.update',['employee_payment'=>$employee_payment])}}">
                            @csrf
                            @method('PUT ')
                            {!!
                                Form::select()
                                ->setLabel('Craftsman')
                                ->setName('craftsman_id')
                                ->setPlaceHolder('Select Payable Craftsman')
                                ->setValue($employee_payment->transactionable_id)
                                ->setOptions($employees)
                                ->setOptionBuilder(
                                    function($value) {
                                        return [ $value->id,$value->name];
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
