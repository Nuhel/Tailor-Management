@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Employee List</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masters as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->mobile }}</td>
                                        <td>{{ $value->address }}</td>
                                        <td>{{ $value->salary }}</td>
                                        <td>
                                            <a href="{{ route('masters.show', ['master' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-eye" aria-hidden="true">
                                                View
                                                </i>
                                            </a>
                                            <a href="{{ route('masters.edit', ['master' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit" aria-hidden="true">
                                                Edit
                                                </i>
                                            </a>
                                            <form action="{{ route('masters.destroy', ['master' => $value->id]) }}"
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
