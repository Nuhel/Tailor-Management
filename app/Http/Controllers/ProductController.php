<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use Mavinoo\Batch\BatchFacade as Batch;
use App\DataTables\ProductStockDataTable;
use App\Http\Requests\StockManageRequest;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $dataTable){
        $categories = Category::all();
        return $dataTable->render('product.index',['heading'=>'Products', 'categories'=>$categories]);
    }

    public function manageStock(ProductStockDataTable $dataTable){
        return $dataTable->render('product.manage-stock',['heading'=>'Manage Stock']);
    }

    public function updateStock(StockManageRequest $request){
        return Batch::update(new Product(), $request->products, 'id');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "category_id" => "required|numeric|exists:App\Models\Category,id",
            "price" => "required|numeric",
            "supplier_price" => "nullable|numeric",
            'stock' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->supplier_price = $request->supplier_price;
        $product->stock = $request->stock;
        return $this->redirectWithAlert($product->save());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit')->with('product', $product)->with('categories',$categories);
    }


    public function update(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "category_id" => "required|numeric|exists:App\Models\Category,id",
            "price" => "required|numeric",
            "supplier_price" => "nullable|numeric",
            'stock' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors());
        }
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->supplier_price = $request->supplier_price;
        $product->stock = $request->stock;
        return $this->redirectWithAlert($product->update());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $this->redirectWithAlert($product->delete());
    }
}
