<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 2;
        Product::factory()->count($count)
            ->afterCreating(function (Product $product) {
                $product->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Product',
                        'translationable_id' => $product->uid,
                        'locale' => 'en',
                        'title' => 'title'
                    ])->make()
                );
                $product->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Product',
                        'translationable_id' => $product->uid,
                        'locale' => 'en',
                        'title' => 'description'
                    ])->make()
                );

                // Create Nepali translation
                $product->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Product',
                        'translationable_id' => $product->uid,
                        'locale' => 'ne',
                        'title' => 'title'
                    ])->make()
                );
                $product->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Product',
                        'translationable_id' => $product->uid,
                        'locale' => 'ne',
                        'title' => 'description'
                    ])->make()
                );
            })->create();
    }
}
