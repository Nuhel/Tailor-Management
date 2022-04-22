<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(500,1500);
        return [
            'name' => "P- ".$this->faker->name(),
            'category_id' => $this->faker->numberBetween(1,15),
            'price' => $price,
            'supplier_price' => $price - $this->faker->numberBetween(10,100),
            'stock' => $this->faker->numberBetween(10,50),
        ];
    }
}
