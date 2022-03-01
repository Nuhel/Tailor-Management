<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class EnsureStockValidator implements Rule
{

    private $requestProducts;
    public function __construct($requestProducts)
    {
        $this->requestProducts = $requestProducts;
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
        $key = Str::of($attribute)->replace('quantity','id')->replace('products.','');
        $productId = Arr::get($this->requestProducts,$key.'');

        if (Product::where('id', $productId)->exists()) {
            $product = Product::find($productId);
            return $value<=$product->stock;
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
        return 'The validation error message.';
    }
}
