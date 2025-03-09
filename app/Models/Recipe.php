<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Ingredient;
use App\Models\Step;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'slug', 'description', 'email'];
    
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


    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('measure_amount', 'measure_unit');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
}
