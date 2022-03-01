<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class EnsureStock implements Rule
{

    private $requestProducts;
    private $route;
    private $max = 0;
    private $order;
    public function __construct($requestProducts, $route,$order)
    {
        $this->requestProducts = $requestProducts;
        $this->order = $order;
        $this->route = $route;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $previousQuantity = 0;
        if($this->order != null && $this->order->products != null){
            $index = Str::of($attribute)->replace('.quantity','')->replace('products.','').'';
            $previousProduct = $this->order->products->get($index);

            if($previousProduct != null){
                $previousQuantity = $this->order->products->get($index)->quantity;
            }
        }




        $key = Str::of($attribute)->replace('quantity','id')->replace('products.','');
        $productId = Arr::get($this->requestProducts,$key.'');

        if (Product::where('id', $productId)->exists()) {
            $product = Product::find($productId);
            $this->max = $product->stock + $previousQuantity;
            return $value <= $this->max;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Quantity can not be greater than '.$this->max;
    }
}
