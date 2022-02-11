



<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <small>Products</small>
            <select name="transactionType" id="" class="form-control form-control-sm js-example-basic-single" wire:model="product">
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{$product->id}}" {{$selectedProducts->has($product->id)?"disabled":""}}>{{$product->name}} </option>
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
                    <th class="w-25">Qty</th>
                    <th class="text-center w-10">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedProducts as $selectedProduct)
                <tr>
                    <td>{{$selectedProduct['name']}}</td>
                    <td >{{$selectedProduct['price']}}</td>
                    <td >
                        <input type="number" class="form-control form-control-sm">
                    </td>
                    <td class="text-center"> <button type="button" class="btn btn-danger btn-sm" wire:click="removeProduct({{ $selectedProduct['id'] }})"><i class="fa fa-trash"></i></button> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

@push('inner-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('select2:select', function (e) {
            var data = e.params.data;
            Livewire.emit('updatedProduct',data.id);
        });


        window.addEventListener('updatedProduct', event => {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-single').on('select2:select', function (e) {
                var data = e.params.data;
                Livewire.emit('updatedProduct',data.id);
            });
        })

    });


</script>
@endpush

@push('inner-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

