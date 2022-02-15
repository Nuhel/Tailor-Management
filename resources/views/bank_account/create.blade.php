@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Insert Bank</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bank_accounts.store') }}">
                            @csrf

                            {!!
                                Form::select()
                                ->setLabel('Bank')
                                ->setName('bank_id')
                                ->setPlaceHolder('Select Bank')
                                ->setValue()
                                ->setOptions($banks)
                                ->setOptionBuilder(
                                    function($value) {
                                        return [$value->id,$value->name];
                                    }
                                )
                                ->render()
                            !!}

                            {!!Form::input()->setName('number')->setValue('')->setLabel('Account Number')->setPlaceholder('Account Number')->render()!!}
                            {!!Form::input()->setName('card')->setValue('')->setLabel('Card Number')->setPlaceholder('Card Number')->render()!!}
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
