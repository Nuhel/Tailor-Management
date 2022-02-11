@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Product</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}">
                            @csrf
                            @method('put')


                            <div class="form-group ">
                                <label class="form-inline">Product Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Product Name" value="{{ $product->name }}">
                                @error('name')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <select name="category_id" id="" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{($product->category->id== $category->id?"selected":"" )}}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label class="form-inline">Product Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Enter Product Price"
                                    value="{{ $product->price }}">
                                @error('price')
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
