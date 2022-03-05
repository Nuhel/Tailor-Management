@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update {{$personRole}}</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{$route}}">
                            @csrf
                            @method('put')

                            {!!Form::input()->setName('name')->setValue($person->name)->setLabel()->setPlaceholder()->render()!!}
                            {!!Form::input()->setName('mobile')->setValue($person->mobile)->setLabel()->setPlaceholder()->render()!!}
                            {!!Form::textarea()->setName('address')->setValue($person->address)->setLabel()->setPlaceholder()->render()!!}

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
