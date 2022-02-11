<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class OrderProduct extends Component
{
    public $selectedProducts;
    public $products;
    public $product;

    protected $listeners = ['updatedProduct'];

    public function mount(){
        $this->selectedProducts = collect();
        $this->products = Product::all();
    }

    public function render()
    {
        return view('livewire.order-product');
    }

    public function removeProduct($id,){
        $this->selectedProducts->forget($id);
    }

    public function updatedProduct($product){
        //dd($product);
        $this->product = $product;
        if(! $this->selectedProducts->has($product)){
            if($this->products->contains('id',$product)){
                $this->selectedProducts->put(
                    $product,
                    $this->products->where('id',$product)->first()
                );


            }
        }
        $this->dispatchBrowserEvent('updatedProduct', ['newName' => "sdsd"]);
    }
}
