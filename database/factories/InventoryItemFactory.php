<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InventoryItem::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(3, true),
            'sku'         => strtoupper($this->faker->bothify('SKU-####')),
            'description' => $this->faker->sentence(),
        ];
    }
}
