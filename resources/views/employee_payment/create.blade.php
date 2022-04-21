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
                                ->setLabel('Craftsman')
                                ->setName('craftsman_id')
                                ->setPlaceHolder('Select Payable Craftsman')
                                ->setValue()
                                ->setOptions($employees)
                                ->setOptionBuilder(
                                    function($value) {
                                        return [ $value->id,$value->name];
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
