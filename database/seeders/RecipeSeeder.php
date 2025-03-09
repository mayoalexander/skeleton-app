<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $recipes = [
            [
                'name' => 'Spaghetti Carbonara',
                'description' => 'A classic Italian pasta dish with creamy egg sauce, pancetta, and cheese.',
                'ingredients' => json_encode(['spaghetti', 'eggs', 'pecorino cheese', 'pancetta', 'black pepper']),
                'steps' => json_encode([
                    'Boil spaghetti in salted water.',
                    'Fry pancetta until crispy.',
                    'Mix eggs and cheese in a bowl.',
                    'Combine spaghetti with pancetta and egg mixture.',
                    'Stir well and serve with black pepper.'
                ]),
                'email' => 'chef@example.com',
                'slug' => Str::slug('Spaghetti Carbonara'),
            ],
            [
                'name' => 'Classic Pancakes',
                'description' => 'Fluffy pancakes made with simple ingredients, perfect for breakfast.',
                'ingredients' => json_encode(['flour', 'milk', 'eggs', 'sugar', 'baking powder', 'butter']),
                'steps' => json_encode([
                    'Mix dry ingredients in a bowl.',
                    'Whisk in milk and eggs.',
                    'Heat butter in a pan and pour batter.',
                    'Cook until bubbles form, then flip.',
                    'Serve with syrup and fruit.'
                ]),
                'email' => 'baker@example.com',
                'slug' => Str::slug('Classic Pancakes'),
            ],
            [
                'name' => 'Chicken Tikka Masala',
                'description' => 'A rich and creamy Indian dish with spiced tomato-based sauce.',
                'ingredients' => json_encode(['chicken', 'yogurt', 'garam masala', 'tomato paste', 'cream', 'garlic', 'ginger']),
                'steps' => json_encode([
                    'Marinate chicken in yogurt and spices for 2 hours.',
                    'Grill chicken until golden brown.',
                    'Prepare sauce with tomato paste, garlic, and cream.',
                    'Simmer sauce and add grilled chicken.',
                    'Serve with rice and naan.'
                ]),
                'email' => 'spiceking@example.com',
                'slug' => Str::slug('Chicken Tikka Masala'),
            ],
            [
                'name' => 'Avocado Toast',
                'description' => 'A quick and healthy breakfast with mashed avocado on toast.',
                'ingredients' => json_encode(['bread', 'avocado', 'salt', 'pepper', 'lemon juice', 'red pepper flakes']),
                'steps' => json_encode([
                    'Toast the bread until golden brown.',
                    'Mash avocado with lemon juice, salt, and pepper.',
                    'Spread avocado mixture on toast.',
                    'Sprinkle red pepper flakes for extra flavor.',
                    'Enjoy immediately.'
                ]),
                'email' => 'healthyeats@example.com',
                'slug' => Str::slug('Avocado Toast'),
            ],
            [
                'name' => 'Beef Tacos',
                'description' => 'Mexican-style beef tacos with fresh toppings.',
                'ingredients' => json_encode(['ground beef', 'onion', 'garlic', 'cumin', 'chili powder', 'tortillas', 'lettuce', 'tomato', 'cheese']),
                'steps' => json_encode([
                    'Cook beef with onions, garlic, and spices.',
                    'Warm tortillas in a pan.',
                    'Assemble tacos with beef, lettuce, tomato, and cheese.',
                    'Serve with lime and salsa.',
                    'Enjoy your delicious tacos!'
                ]),
                'email' => 'tacoman@example.com',
                'slug' => Str::slug('Beef Tacos'),
            ]
        ];

        // Insert each recipe into the database
        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
