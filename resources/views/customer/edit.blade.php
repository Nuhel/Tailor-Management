@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Customer</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('customers.update',  ['customer'=> $customer->id])}}">
                            @csrf
                            @method('put')

                            {!!Form::input()->setName('name')->setValue($customer->name)->setLabel()->setPlaceholder()->render()!!}
                            {!!Form::input()->setName('mobile')->setValue($customer->mobile)->setLabel()->setPlaceholder()->render()!!}
                            {!!Form::textarea()->setName('address')->setValue($customer->address)->setLabel()->setPlaceholder()->render()!!}

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
