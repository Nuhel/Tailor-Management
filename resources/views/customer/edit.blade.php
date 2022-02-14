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


                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"name",
                                    'value' => $customer->name
                                ]
                            ])

                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"mobile",
                                    'value' => $customer->mobile
                                ]
                            ])

                            @include('layout.inputs.textarea',[
                                'attributes' => [
                                    'name' =>"address",
                                    'value' => $customer->address
                                ]
                            ])





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
