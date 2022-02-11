@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Product List</strong></h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product-add-modal">
                            Add Product
                        </button>

                        @if (Session::has('response'))
                            <p>{{ Session::get('response')['message'] }}</p>
                        @endif

                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->category->name }}</td>
                                        <td>{{ $value->price }}</td>
                                        <td>Id Card</td>
                                        <td>
                                            <a href="{{ route('products.show', ['product' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-eye" aria-hidden="true">
                                                    View
                                                </i>
                                            </a>
                                            <a href="{{ route('products.edit', ['product' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit" aria-hidden="true">
                                                    Edit
                                                </i>
                                            </a>
                                            <form action="{{ route('products.destroy', ['product' => $value->id]) }}"
                                                method="post" class="d-inline-block">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm mr-2">
                                                    <i class="fa fa-trash" aria-hidden="true">
                                                        Delete
                                                    </i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('product.add-modal',['categories'=>$categories])
@endsection

@if (Session::has('action') && Session::get('action') == 'modal-open')
    @section('script')
        <script>
            $('#product-add-modal').modal('show');
        </script>
    @endsection
@endif
