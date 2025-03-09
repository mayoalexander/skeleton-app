<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // recipes
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('email');
            $table->timestamps();
        });

        // ingredients
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        // ingredients pivot
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->text('measure_amount');
            $table->text('measure_unit');
            $table->foreignId('recipe_id')->constrained();
            $table->foreignId('ingredient_id')->constrained();
        });

        // steps
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('step_number');
            $table->text('description');
            $table->foreignId('recipe_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
        Schema::dropIfExists('ingredient_recipe');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('recipes');
    }
};
