<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{

    public function definition()
    {
        $name = fake()->text(120);

        return [
            'name' => $name,
        ];
    }

    public function amount()
    {
    }

    public function unit()
    {
    }
}
