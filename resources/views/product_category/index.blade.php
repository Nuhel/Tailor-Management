@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Category List</strong></h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#category-add-modal">
                            Add Category
                        </button>

                        {{-- @if (Session::has('response'))
                            <p>{{ Session::get('response')['message'] }}</p>
                        @endif --}}

                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="tablecolor emp">
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $value)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('categories.show', ['category' => $value->id]) }}" class="btn btn-outline-primary btn-sm mr-2">
                                                    <i class="fa fa-eye" aria-hidden="true">
                                                    View
                                                    </i>
                                                </a>
                                                <a
                                                    href="{{ route('categories.edit', ['category' => $value->id]) }}" class="btn btn-outline-primary btn-sm mr-2">
                                                    <i class="fa fa-edit" aria-hidden="true">
                                                    Edit
                                                    </i>
                                                </a>
                                                <form
                                                    action="{{ route('categories.destroy', ['category' => $value->id]) }}"
                                                    method="post" class="d-inline-block">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
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
        @include('product_category.add-modal')
    @endsection
    @if (Session::has('action') && Session::get('action')=="modal-open")
        @section('script')
        <script>
            $('#category-add-modal').modal('show');
        </script>
        @endsection
    @endif
