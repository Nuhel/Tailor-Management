@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Order List</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>SL</th>
                                    <th>Customer Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $value)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $value->customer->name }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', ['order' => $value]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-eye" aria-hidden="true">
                                                View
                                                </i>
                                            </a>
                                            <a href="{{ route('orders.edit', ['order' => $value]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit" aria-hidden="true">
                                                Edit
                                                </i>
                                            </a>
                                            <form action="{{ route('orders.destroy', ['order' => $value]) }}"
                                                method="post" class="d-inline-block">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                class="btn btn-outline-danger btn-sm mr-2">
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
@endsection
