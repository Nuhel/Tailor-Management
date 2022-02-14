@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Employee</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('employees.update',  ['employee'=> $employee->id])}}">
                            @csrf
                            @method('put')

                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"name",
                                    'value' => $employee->name
                                ]
                            ])

                            @include('layout.inputs.input',[
                                'attributes' => [
                                    'name' =>"mobile",
                                    'value' => $employee->mobile
                                ]
                            ])

                            @include('layout.inputs.textarea',[
                                'attributes' => [
                                    'name' =>"address",
                                    'value' => $employee->address
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
