<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{

    public $ingredients;
    
    public function run()
    {
        // Create ingredients
        $ingredientNames = ['Salt', 'Sugar', 'Garlic', 'Onion', 'Olive Oil', 'Butter', 'Milk', 'Eggs', 'Flour', 'Tomato'];;
        $ingredients = $this->ingredients = collect($ingredientNames)->map(fn($name) => Ingredient::create(['name' => $name]));

        $this->createCypressTestUser();

        // ✅ Create 50 random recipes
        Recipe::factory()
            ->count(50)
            ->create()
            ->each(function ($recipe) use ($ingredients) {
                // Attach random ingredients
                $recipe->ingredients()->attach(
                    $ingredients->random(min(rand(2, 6), $ingredients->count()))->pluck('id'),
                    [
                        'measure_amount' => rand(1, 3),
                        'measure_unit' => fake()->randomElement(['oz', 'cups', 'tbsp', 'tsp'])
                    ]
                );

                // Attach steps
                for ($i = 1; $i <= rand(3, 6); $i++) {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'step_number' => $i,
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

    private function createCypressTestUser () {
        // ✅ Create one specific recipe for Cypress testing
        $specificRecipe = Recipe::create([
            'name' => 'Wild Salmon Caesar Salad',
            'slug' => Str::slug('Wild Salmon Caesar Salad'),
            'description' => 'A creamy and delicious salmon salad dish.',
            'email' => 'johndoe@wildalaskan.com',
        ]);

        // Attach specific ingredients
        $specificRecipe->ingredients()->attach(
            $this->ingredients->whereIn('name', ['Potato', 'Milk', 'Butter'])->pluck('id'),
            [
                'measure_amount' => 1,
                'measure_unit' => 'cup'
            ]
        );

        // Attach steps
        Step::create([
            'recipe_id' => $specificRecipe->id,
            'step_number' => 1,
            'description' => 'Preheat oven to 375°F and prepare potatoes.'
        ]);
        Step::create([
            'recipe_id' => $specificRecipe->id,
            'step_number' => 2,
            'description' => 'Layer potatoes with butter and milk, then bake for 45 minutes.'
        ]);
    }
}
