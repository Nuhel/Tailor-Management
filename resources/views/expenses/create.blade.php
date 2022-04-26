
@extends('layout.layout')
@section('css')
    @livewireStyles
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Add Expense</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('expenses.store')}}">
                            @csrf

                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments',[
                                        "bankType"=>old('bank_type'),
                                        "bankId"=>old('bank_id'),
                                        "accountId"=>old('account_id'),
                                    ])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Expense Category</label>
                                <select class="form-control" name="expense_category_id">
                                    <option value=''>Select Expense Category</option>
                                    @foreach ($expenseCategories as $expenseCategory)
                                        <option value="{{$expenseCategory->id}}" {{old('expense_category_id') == $expenseCategory->id?"selected":""}}>{{$expenseCategory->name}}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror

                            </div>


                            <div class="form-group" id="amount">
                                <label class="form-inline">Amount</label>
                                <input type="text" name="amount" class="form-control form-control-sm" placeholder="Enter Amount" value="{{old('amount')}}">
                                @error('amount')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="date">
                                <label class="form-inline">Expense Date</label>
                                <input type="date" name="date" class="form-control form-control-sm" value="{{old('date')}}">
                                @error('date')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror
                            </div>
                            {!!Form::textarea()->setName('description')->setValue(old('description'))->setLabel()->setPlaceholder()->render()!!}

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-success mr-3" >Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @livewireScripts
@endsection
