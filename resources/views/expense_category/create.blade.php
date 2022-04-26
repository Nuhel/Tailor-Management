@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Add Expense Category</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('expense-categories.store') }}">
                            @csrf
                            {!!Form::input()->setName('name')->setValue()->setLabel()->setPlaceholder()->render()!!}
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
