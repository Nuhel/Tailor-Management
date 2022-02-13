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
                            <div class="form-group ">
                            <label class="form-inline">Customer Name</label>
                            <input type="text" name="name" id="empName" class="form-control" placeholder="Enter Customer Name">
                        </div>
                        <div class="form-group">
                            <label class="form-inline">Customer Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Customer Mobile">
                        </div>



                        <div class="form-group">
                            <label class="form-inline">Customer Address</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Enter Employee Address"></textarea>
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
