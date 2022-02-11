@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Master</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('masters.update', ['master' => $master->id]) }}">
                            @csrf
                            @method('put')
                            <div class="form-group ">
                                <label class="form-inline">Master Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Master Name" value="{{ $master->name }}">
                                @error('name')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-inline">Master Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="form-control"
                                    placeholder="Enter Master Mobile" value="{{ $master->mobile }}">
                                @error('mobile')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-inline">Master Salary</label>
                                <input type="number" name="salary" class="form-control" placeholder="Enter Master Salary"
                                    value="{{ $master->salary }}">
                                @error('salary')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-inline">Master Address</label>
                                <textarea name="address" id="address" class="form-control"
                                    placeholder="Enter Master Address">{{ $master->address }}</textarea>
                                @error('address')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
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
