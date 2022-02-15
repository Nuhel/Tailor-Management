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
                        <form method="POST" action="{{ route('banks.update', ['bank' => $bank->id]) }}">
                            @csrf
                            @method('put')

                            {!!Form::input()->setName('name')->setValue( $bank->name)->render()!!}
                            {!!
                                Form::select()
                                ->setLabel('Bank Type')
                                ->setName('type')
                                ->setValue($bank->type)
                                ->setOptions(
                                    ['General Bank','Mobile Bank']
                                )
                                ->setOptionBuilder(
                                    function($value) {
                                        return [$value,$value];
                                    }
                                )
                                ->render()
                            !!}



                            {!!Form::textarea()->setName('address')->setValue($bank->address)->setLabel('Enter Bank Address')->render()!!}


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
