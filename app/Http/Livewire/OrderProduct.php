<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class OrderProduct extends Component
{
    public $cart;
    public $products;
    public $productId;
    public $selectedProductPriceAndQuantity;

    protected $listeners = ['updatedProduct'];

    public function mount($oldCart){
        $this->cart = collect();
        $this->selectedProductPriceAndQuantity = collect();
        $this->products = Product::all();

        foreach($oldCart as $oldItem){
            $this->addProductToSelected($oldItem['id'],$oldItem['price'],$oldItem['quantity']);
        }
    }

    public function addProductToSelected($productId,$price = null, $quantity = 1){
        if($this->products->contains('id',$productId)){
            $product = $this->products->where('id',$productId)->first();
            $this->cart->put(
                $productId,
                [
                    'product'   => $product,
                    'price'     => $price??$product['price'],
                    'quantity'  => $quantity,
                ]

            );
        }
    }

    public function render()
    {
        return view('order.livewire.order-product');
    }

    public function removeProduct($id){
        $this->cart->forget($id);
        $this->dispatchBrowserEvent('cartUpdated', ['newName' => "sdsd"]);
    }

    public function updatedProduct($productId){
        if(! $this->cart->pluck('product')->has($productId)){
            $this->addProductToSelected($productId);
        }
        $this->dispatchBrowserEvent('cartUpdated', ['newName' => "sdsd"]);
    }
}
