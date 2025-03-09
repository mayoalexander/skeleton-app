<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use HasFactory;

    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'ingredients' => json_decode($this->ingredients), // Convert JSON to array
            'steps' => json_decode($this->steps),
            'email' => $this->email,
            'slug' => $this->slug
        ];
    }
}
