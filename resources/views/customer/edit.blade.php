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
                            <div class="form-group ">
                            <label class="form-inline">Employee Name</label>
                            <input type="text" name="name" id="empName" class="form-control" placeholder="Enter customer Name" value="{{$customer->name}}">
                        </div>
                        <div class="form-group">
                            <label class="form-inline">Employee Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter customer Mobile" value="{{$customer->mobile}}">
                        </div>


                        <div class="form-group">
                            <label class="form-inline">Employee Address</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Enter customer Address">{{$customer->address}}</textarea>
                        </div>
                        

                     

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
