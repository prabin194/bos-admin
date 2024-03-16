<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 1;
        Category::factory()->count($count)
            ->afterCreating(function (Category $category) {
                // Create English translation
                $category->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Category',
                        'translationable_id' => $category->uid,
                        'locale' => 'en',
                        'title' => 'title'
                    ])->make()
                );

                // Create Nepali translation
                $category->translations()->save(
                    Translation::factory()->state([
                        'translationable_type' => 'App/Models/Category',
                        'translationable_id' => $category->uid,
                        'locale' => 'ne',
                        'title' => 'title'
                    ])->make()
                );
            })->create();
    }
}
