@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Bank Account List</strong></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="tablecolor emp">
                                    <th>Serial No</th>
                                    <th>Bank</th>
                                    <th>Account Number</th>
                                    <th>Card</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankAccounts as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->bank->name }}</td>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ $value->card }}</td>
                                        <td>
                                            <a
                                                href="{{ route('bank_accounts.show', ['bank_account' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-eye" aria-hidden="true">
                                                View
                                                </i>
                                            </a>
                                            <a
                                                href="{{ route('bank_accounts.edit', ['bank_account' => $value->id]) }}"
                                                class="btn btn-outline-primary btn-sm mr-2">
                                                <i class="fa fa-edit" aria-hidden="true">
                                                Edit
                                                </i>
                                            </a>
                                            <form
                                                action="{{ route('bank_accounts.destroy', ['bank_account' => $value->id]) }}"
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
