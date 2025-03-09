<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory {

    public function definition()
    {
        $description = fake()->text(120);

        return [
            'step_number' => 1,
            'description' => $description,
        ];
    }
}
