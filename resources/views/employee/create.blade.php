@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Insert Employee</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('employees.store')}}">
                            @csrf
                            <div class="form-group ">
                            <label class="form-inline">Employee Name</label>
                            <input type="text" name="name" id="empName" class="form-control" placeholder="Enter Employee Name">
                        </div>
                        <div class="form-group">
                            <label class="form-inline">Employee Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Employee Mobile">
                        </div>

                        <div class="form-group">
                            <label class="form-inline">Employee Address</label>
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
