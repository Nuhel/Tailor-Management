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
                        <form method="POST" action="{{ route('products.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label class="form-inline">Product Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Product Name">
                            </div>

                            <div class="form-group">
                                <select name="category_id" id="" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group ">
                                <label class="form-inline">Product Price</label>
                                <input type="text" name="price"class="form-control"
                                    placeholder="Enter Product Price">
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
