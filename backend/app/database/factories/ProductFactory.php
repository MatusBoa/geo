<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Container\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Container\Product\Model\Product>
 */
class ProductFactory extends Factory
{
    /**
     * @inheritDoc
     */
    protected $model = Product::class;

    /**
     * @inheritDoc
     *
     * @return array<\App\Container\Product\Model\Product::ATTR_*, mixed>
     */
    public function definition(): array
    {
        return [
            Product::ATTR_NAME => $this->faker->word,
            Product::ATTR_PRICE => $this->faker->randomFloat(2, 500, 1000),
        ];
    }
}
