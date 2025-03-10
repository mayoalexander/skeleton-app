<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the endpoint returns an error when no search parameters are provided.
     */
    public function testSearchReturnsErrorWhenNoParametersProvided()
    {
        $response = $this->getJson('/api/recipes/search');

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'At least one search parameter is required'
            ]);
    }

    /**
     * Test searching by keyword returns the expected recipe.
     */
    public function testSearchByKeywordReturnsMatchingRecipe()
    {
        // Create a recipe with a specific keyword in its name/description.
        $recipe = Recipe::factory()->create([
            'name' => 'Delicious Chicken Soup',
            'description' => 'A tasty soup with chicken and vegetables',
        ]);

        // Index the recipe for search.
        $recipe->searchable();

        // Search using the keyword 'Chicken'.
        $response = $this->getJson('/api/recipes/search?keyword=Chicken');

        $response->assertStatus(200);
        $data = $response->json();

        // Assert that at least one recipe is returned and the first one matches our recipe.
        $this->assertNotEmpty($data['data']);
        $this->assertEquals($recipe->id, $data['data'][0]['id']);
    }

    /**
     * Test searching by author email returns the expected recipe.
     */
    public function testSearchByAuthorEmailReturnsMatchingRecipe()
    {
        $recipe = Recipe::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test Recipe',
        ]);
        $recipe->searchable();

        $response = $this->getJson('/api/recipes/search?author_email=test@example.com');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertNotEmpty($data['data']);
        $this->assertEquals('Test Recipe', $data['data'][0]['name']);
    }

    /**
     * Test searching by ingredient returns the expected recipe.
     */
    public function testSearchByIngredientReturnsMatchingRecipe()
    {
        // Create a recipe.
        $recipe = Recipe::factory()->create([
            'name' => 'Pasta with Tomato Sauce',
        ]);

        // Create and attach an ingredient to the recipe.
        // (This assumes you have a relationship named "ingredients" on your Recipe model.)
        $recipe->ingredients()->create([
            'name' => 'Tomato',
        ]);

        // Index the recipe including its ingredients.
        $recipe->searchable();

        // Search by ingredient.
        $response = $this->getJson('/api/recipes/search?ingredient=Tomato');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertNotEmpty($data['data']);
        $this->assertEquals('Pasta with Tomato Sauce', $data['data'][0]['name']);
    }
}
