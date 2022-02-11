@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Master {{ $master->name}}</strong></h2>
                    </div>
                    <div class="card-body ">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="tablecolor emp">
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                         <tr>
                                            <td>{{ $master->name}}</td>
                                            <td>{{ $master->mobile}}</td>
                                            <td>{{ $master->address}}</td>
                                            <td>{{ $master->salary}}</td>
                                        </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


