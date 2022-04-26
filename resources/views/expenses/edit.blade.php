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
                        <h2><strong>Update Expense</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('expenses.update', ['expense' => $expense]) }}">
                            @csrf
                            @method('put')

                            <div class="card">
                                <div class="card-body">
                                    @livewire('order-payments',[
                                        "bankType"=>old('bank_type',$bankType),
                                        "bankId"=>old('bank_id',$bankId),
                                        "accountId"=>old('account_id',$expense->sourceable_id),
                                    ])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Expense Category</label>
                                <select class="form-control" name="expense_category_id">
                                    <option value=''>Select Expense Category</option>
                                    @foreach ($expenseCategories as $expenseCategory)
                                        <option value="{{$expenseCategory->id}}" {{old('expense_category_id',$expense->transactionable_id) == $expenseCategory->id?"selected":""}}>{{$expenseCategory->name}}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror

                            </div>


                            <div class="form-group" id="amount">
                                <label class="form-inline">Amount</label>
                                <input type="text" name="amount" class="form-control form-control-sm" placeholder="Enter Amount" value="{{old('amount',$expense->amount)}}">
                                @error('amount')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="date">
                                <label class="form-inline">Expense Date</label>
                                <input type="date" name="date" class="form-control form-control-sm" value="{{old('date',Carbon::parse($expense->transaction_date)->format('Y-m-d'))}}">
                                @error('date')
                                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback" role="alert">{{$message}}</span>
                                @enderror
                            </div>

                            {!!Form::textarea()->setName('description')->setValue($expense->description)->setLabel()->setPlaceholder()->render()!!}
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
@section('script')
    @livewireScripts
@endsection
