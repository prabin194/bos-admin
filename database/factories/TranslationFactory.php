<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => $this->faker->uuid,
            'translationable_type' => '',
            'translationable_id' => '',
            'locale' => $this->faker->locale,
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
        ];
    }

    public function configure(): TranslationFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'translationable_type' => $attributes['translationable_type'] ?? Product::class,
                'translationable_id' => $attributes['translationable_id'] ?? $this->faker->uuid,
                'locale' => $attributes['locale'] ?? $this->faker->locale,
                'title' => $attributes['title'] ?? $this->faker->title,
            ];
        });
    }
}
