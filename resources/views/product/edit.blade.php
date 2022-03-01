@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Update Product</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}">
                            @csrf
                            @method('put')

                            {!!Form::input()->setName('name')->setValue(old('name',$product->name))->setLabel('Product Name')->setPlaceholder('Product Name')->render()!!}

                            {!!
                                Form::select()
                                ->setLabel('Product Category')
                                ->setName('category_id')
                                ->setPlaceHolder('Select Product Category')
                                ->setValue($product->category->id)
                                ->setOptions($categories)
                                ->setOptionBuilder(
                                    function($value) {
                                        return [ $value->id,$value->name];
                                    }
                                )
                                ->render()
                            !!}
                            {!!Form::input()->setName('price')->setValue(old('price',$product->price))->setLabel('Product Price')->setPlaceholder('Product Price')->setType('number')->render()!!}
                            {!!Form::input()->setName('stock')->setValue(old('stock',$product->stock))->setLabel('Product Stock')->setPlaceholder('Product Stock')->setType('number')->render()!!}



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
