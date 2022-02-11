@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$service->name}}</h5>
                        <p class="card-text mt-3"><strong>Measurements: </strong>
                            @forelse ($service->measurements as $measurement)
                                {{$measurement->name}} {{$loop->last?"":","}}
                            @empty
                                No measurements
                            @endforelse
                        </p>

                        <p class="card-text mt-3">
                            <strong>Designs</strong>
                        </p>

                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="tablecolor emp">
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Styles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service->designs as $value)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>
                                                <p>
                                                    @forelse ($value->styles as $style)
                                                        {{$style->name}} {{$loop->last?"":","}}
                                                    @empty
                                                        No Style
                                                    @endforelse
                                                </p>
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
    </div>
@endsection


