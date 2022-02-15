@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Add Category</strong></h2>
                    </div>
                    <div class="card-body">
                        @include('product_category.add-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
