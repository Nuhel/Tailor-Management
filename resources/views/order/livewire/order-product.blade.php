



<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <small>Products</small>
            <select id="" class="form-control form-control-sm product-select" wire:model="productId">
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{$product->id}}" {{collect($cart)->pluck('product')->contains('id',$product->id)?"disabled":""}}>{{$product->name}} </option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="col-md-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="w-25">Price</th>
                    <th class="w-25">Supplier Price</th>
                    <th class="w-25">Qty</th>
                    <th class="text-center">Total</th>
                    <th class="text-center w-10">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cart as $item)
                    <tr class="cart-product">
                        <td>
                            <small>{{$item['product']['name']}}</small>
                            <input type="hidden" name="products[{{$loop->index}}][id]" value="{{$item['product']['id']}}">
                        </td>
                        <td >
                            {!!Form::input()
                            ->appendInputClass('price')
                            ->setName('products['.$loop->index.'][price]' )
                            ->setEnableLabel(false)->setPlaceHolder('price')
                            ->setValue(old('products.'.$loop->index.'.price',$item['price']))
                            ->setType('number')->setError('products.'.$loop->index.'.price')!!}

                        </td>

                        <td >
                            {!!Form::input()
                            ->setName('products['.$loop->index.'][supplier_price]' )
                            ->setEnableLabel(false)->setPlaceHolder('supplier_price')
                            ->setValue(old('products.'.$loop->index.'.supplier_price',$item['supplier_price']))
                            ->setType('number')->setError('products.'.$loop->index.'.supplier_price')!!}
                        </td>
                        <td >
                            {!!Form::input()
                            ->appendInputClass('quantity')
                            ->setName('products['.$loop->index.'][quantity]')
                            ->setEnableLabel(false)->setPlaceHolder('quantity')
                            ->setValue(old('products.'.$loop->index.'.quantity',$item['quantity']))
                            ->setType('number')
                            ->setError('products.'.$loop->index.'.quantity')!!}
                            <span>Max {{!$onEdit?$item['stock']:$item['stock']+$item['quantity']}}</span>


                        </td>
                        <td>
                            <small class="d-block text-center mt-2 totalprice">
                                {{
                                    old('products.'.$loop->index.'.price',$item['price'])??0 *
                                    old('products.'.$loop->index.'.quantity',$item['quantity'])??0
                                }}
                            </small>
                        </td>
                        <td class="text-center"> <button type="button" class="btn btn-danger btn-sm" wire:click="removeProduct({{ $item['product']['id'] }})"><i class="fa fa-trash"></i></button> </td>
                    </tr>
                @empty
                    <input type="hidden" name="products[]">
                    <input type="hidden" name="passProductCheck" value="true">
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@push('inner-script')

<script>
    $(document).ready(function() {
        $('.product-select').select2();
        $('.product-select').on('select2:select', function (e) {
            var data = e.params.data;
            Livewire.emit('updatedProduct',data.id);
        });


        window.addEventListener('cartUpdated', event => {
            $('.product-select').select2();
            $('.product-select').on('select2:select', function (e) {
                var data = e.params.data;
                Livewire.emit('updatedProduct',data.id);
            });
            calculatePayments();
        })

    });


</script>
@endpush


