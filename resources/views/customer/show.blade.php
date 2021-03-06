@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Customer List</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>ID Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                     <tr>
                                        <td>{{ $customer->id}}</td>
                                        <td>{{ $customer->name}}</td>
                                        <td>{{ $customer->mobile}}</td>
                                        <td>{{ $customer->address}}</td>
                                        <td>Id Card</td>
                                    </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


