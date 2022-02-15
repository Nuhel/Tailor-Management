@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Add Product</strong></h2>
                    </div>
                    <div class="card-body">
                        @include('product.add-form',['categories',$categories])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
