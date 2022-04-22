<form method="POST" action="{{ route('products.store') }}">
    @csrf
    {!!Form::input()->setName('name')->setValue()->setLabel('Product Name')->setPlaceholder('Product Name')->render()!!}

    {!!
        Form::select()
        ->setLabel('Product Category')
        ->setName('category_id')
        ->setPlaceHolder('Select Product Category')
        ->setValue()
        ->setOptions($categories)
        ->setOptionBuilder(
            function($value) {
                return [ $value->id,$value->name];
            }
        )
        ->render()
    !!}
    {!!Form::input()->setName('price')->setValue()->setLabel('Product Price')->setPlaceholder('Product Price')->setType('number')->render()!!}
    {!!Form::input()->setName('supplier_price')->setValue()->setLabel('Supplier Price')->setPlaceholder('Supplier Price')->setType('number')->render()!!}
    {!!Form::input()->setName('stock')->setValue(old('stock',1))->setLabel('Product Stock')->setPlaceholder('Product Stock')->setType('number')->render()!!}


    <div class="form-group text-right">
        <button type="submit" class="btn btn-success " name="submit">Submit</button>
    </div>
</form>
