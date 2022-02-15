@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Bank</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bank_accounts.update', ['bank_account' => $bankAccount->id]) }}">
                            @csrf
                            @method('put')




                            {!!
                                Form::select()
                                ->setLabel('Bank')
                                ->setName('bank_id')
                                ->setPlaceHolder('Select Bank')
                                ->setValue($bankAccount->bank->id)
                                ->setOptions($banks)
                                ->setOptionBuilder(
                                    function($value) {
                                        return [$value->id,$value->name];
                                    }
                                )
                                ->render()
                            !!}
                            {!!Form::input()->setName('number')->setValue($bankAccount->number)->setLabel('Account Number')->setPlaceholder('Account Number')->render()!!}
                            {!!Form::input()->setName('card')->setValue($bankAccount->card)->setLabel('Card Number')->setPlaceholder('Card Number')->render()!!}

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
