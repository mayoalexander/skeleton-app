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

        $name = $this->faker->randomElement($recipeNames);

        return [    
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'email' => $this->faker->safeEmail
        ];
    }
}
