@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Bank</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bank_accounts.update', ['bank_account' => $bankAccount->id]) }}">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label class="form-inline">Bank</label>
                                <select name="bank_id" id="" class="form-control">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ $bankAccount->bank->id == $bank->id?"selected":"" }}>{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                                @error('bank_id')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label class="form-inline">Account Number</label>
                                <input type="text" name="number" id="empName" class="form-control"
                                    placeholder="Enter Account Number" value="{{ $bankAccount->number }}">
                                @error('number')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label class="form-inline">Card Number</label>
                                <input type="text" name="card" class="form-control"
                                    placeholder="Enter Card Number" value="{{ $bankAccount->card }}" >
                                @error('card')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
