<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Ingredient;
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

    /**
     * Test searching by keyword, ingredient, and email combined.
     */
    public function testSearchByMultipleParametersReturnsMatchingRecipe()
    {
        // ✅ Create a recipe that matches ALL search criteria
        $recipe = Recipe::factory()->create([
            'name' => 'Scallop & Potato Delight',
            'description' => 'A delicious scallop dish with creamy potatoes.',
            'email' => 'foo@bar.com',
        ]);

        // ✅ Create and attach an ingredient (potato)
        $ingredient = Ingredient::factory()->create([
            'name' => 'Potato',
        ]);

        $recipe->ingredients()->attach($ingredient->id, [
            'measure_amount' => '2',
            'measure_unit' => 'cups',
        ]);

        // ✅ Index the recipe for search
        $recipe->searchable();

        // ✅ Make a search request with all parameters
        $response = $this->getJson('/api/recipes/search?email=foo@bar.com&ingredient=potato&keyword=scallop');

        $response->assertStatus(200);
        $data = $response->json();

        // ✅ Assert that results are returned and the correct recipe is included
        $this->assertNotEmpty($data['data']);
        $this->assertEquals($recipe->id, $data['data'][0]['id']);
    }
}
