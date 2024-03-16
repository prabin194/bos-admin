<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $existingCategory = Category::inRandomOrder()->first();
        $existingUser = User::inRandomOrder()->first();


        return [
            'uid' => $this->faker->uuid,
            'price' => $this->faker->numberBetween(100, 1000),
            'category_id' => $existingCategory->uid,
            'user_id' => $existingUser->uid,
        ];
    }
}
