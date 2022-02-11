@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Bank {{$bank->name}}</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                     <tr>
                                        <td>{{ $bank->name}}</td>
                                        <td>{{ $bank->type}}</td>
                                        <td>{{ $bank->address}}</td>
                                    </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


