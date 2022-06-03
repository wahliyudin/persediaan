<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\Unit;
use App\Models\Warehouse;
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
        return [
            'name' => $this->faker->words(2, true),
            'stock' => $this->faker->numberBetween(5, 10),
            'price' => $this->faker->numberBetween(1_000, 100_000),
            'unit_id' => $this->faker->randomElement(Unit::pluck('id')->toArray()),
            'type_id' => $this->faker->randomElement(Type::pluck('id')->toArray()),
            'warehouse_id' => $this->faker->randomElement(Warehouse::pluck('id')->toArray())
        ];
    }
}
