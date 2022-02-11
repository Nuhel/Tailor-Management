@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Bank Account</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Number</th>
                                    <th>Bank</th>
                                    <th>Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                     <tr>
                                        <td>{{ $bankAccount->number}}</td>
                                        <td>{{ $bankAccount->bank->name}}</td>
                                        <td>{{ $bankAccount->card}}</td>
                                    </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


