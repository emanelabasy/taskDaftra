<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Warehouse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name'     => $this->faker->company().' WarehouseTest',
            'location' => $this->faker->city(),
        ];
    }
}

