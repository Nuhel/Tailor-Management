@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Category</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.update', ['category' => $category->id]) }}">
                            @csrf
                            @method('put')
                            {!!Form::input()->setName('name')->setValue($category->name)->setLabel()->setPlaceholder()->render()!!}
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
