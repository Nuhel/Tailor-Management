@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2><strong>Service List</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Measurements</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>
                                            <p>
                                                @forelse ($value->measurements as $measurement)
                                                    {{$measurement->name}} {{$loop->last?"":","}}
                                                @empty
                                                    No measurements
                                                @endforelse
                                            </p>
                                        </td>
                                        <td>
                                            <a href="{{ route('services.show', ['service' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-eye" aria-hidden="true">
                                                    View
                                                </i>
                                            </a>
                                            <a href="{{ route('services.edit', ['service' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit" aria-hidden="true">
                                                    Edit
                                                </i>
                                            </a>
                                            <form action="{{ route('services.destroy', ['service' => $value->id]) }}"
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

@endsection
