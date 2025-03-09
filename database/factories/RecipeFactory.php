<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    public function definition()
    {
        $recipeNames = [
            'Spaghetti Carbonara',
            'Classic Pancakes',
            'Garlic Butter Chicken',
            'Avocado Toast',
            'Beef Tacos',
            'Homemade Pizza',
            'Chocolate Chip Cookies',
            'Caesar Salad',
            'Lemon Garlic Shrimp Pasta',
            'Stuffed Bell Peppers'
        ];

        return [
            'name' => $this->faker->randomElement($recipeNames), // ✅ Use real recipe names
            'slug' => Str::slug($this->faker->randomElement($recipeNames)),
            'description' => $this->faker->sentence(10),
            'email' => $this->faker->safeEmail
        ];
    }
}
