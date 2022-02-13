<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class OrderProduct extends Component
{
    public $selectedProducts;
    public $products;
    public $product;
    public $oldProductQuantities;

    protected $listeners = ['updatedProduct'];

    public function mount($oldSelectedProducts, $oldProductQuantities){
        $this->oldProductQuantities = $oldProductQuantities;
        $this->selectedProducts = collect();
        $this->products = Product::all();
        foreach($oldSelectedProducts as $oldSelectedProduct){
            if($this->products->contains('id',$oldSelectedProduct)){
                $this->selectedProducts->put(
                    $oldSelectedProduct,
                    $this->products->where('id',$oldSelectedProduct)->first()
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.order-product');
    }

    public function removeProduct($id,){
        $this->selectedProducts->forget($id);
    }

    public function updatedProduct($product){
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
