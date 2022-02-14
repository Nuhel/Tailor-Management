@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Insert Customer</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('customers.store')}}">
                            @csrf


                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"name",
                                    'value' => ""
                                ]
                            ])

                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"mobile",
                                ]
                            ])

                            @include('layout.inputs.textarea',[
                                'attributes' => [
                                    'name' =>"address",
                                    'placeholder' => "Enter Employee Address"
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
