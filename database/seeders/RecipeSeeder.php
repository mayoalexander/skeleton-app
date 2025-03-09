<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        // Create ingredients
        $ingredientNames = ['Salt', 'Sugar', 'Garlic', 'Onion', 'Olive Oil', 'Butter', 'Milk', 'Eggs', 'Flour', 'Tomato'];
        $ingredients = collect($ingredientNames)->map(fn($name) => Ingredient::create(['name' => $name]));

        Recipe::factory()
            ->count(50)
            ->create()
            ->each(function ($recipe) use ($ingredients) {
                // Attach ingredients with randomized amounts
                $recipe->ingredients()->attach(
                    $ingredients->random(min(rand(2, 6), $ingredients->count()))->pluck('id'),
                    [
                        'measure_amount' => rand(1, 3),
                        'measure_unit' => fake()->randomElement(['oz', 'cups', 'tbsp', 'tsp'])
                    ]
                );

                // Attach steps with correct numbering
                for ($i = 1; $i <= rand(3, 6); $i++) {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'step_number' => $i, // ✅ Correct numbering
                        'description' => fake()->randomElement([
                            'Preheat oven to 350°F.',
                            'Chop and prepare all ingredients.',
                            'Mix dry and wet ingredients separately.',
                            'Cook in a preheated skillet for 10 minutes.',
                            'Let the dish rest before serving.',
                            'Garnish with fresh herbs and serve.'
                        ])
                    ]);
                }
            });
    }
}
