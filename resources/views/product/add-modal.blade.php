<!-- Modal -->
<div class="modal fade" id="product-add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label class="form-inline">Product Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Product Name" value="{{old('name')}}">
                                    @error('name')
                                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <select name="category_id" id="" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{(old('category_id') == $category->id?"selected":"" )}}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label class="form-inline">Product Price</label>
                                <input type="text" name="price" class="form-control"
                                    placeholder="Enter Product Price" value="{{old('price')}}">
                                    @error('price')
                                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success " name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
