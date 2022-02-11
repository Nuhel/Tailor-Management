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
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="tablecolor emp">
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                         <tr>
                                            <td>{{ $employee->id}}</td>
                                            <td>{{ $employee->name}}</td>
                                            <td>{{ $employee->mobile}}</td>
                                            <td>{{ $employee->address}}</td>
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


