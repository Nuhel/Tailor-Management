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
                        <form method="POST" action="{{ route('categories.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label class="form-inline">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Category Name" value="{{old('name')}}">
                                @error('name')
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
