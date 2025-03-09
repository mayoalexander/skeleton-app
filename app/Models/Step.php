<?php

namespace App\Models;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Step extends Model
{
    use HasFactory;
    protected $fillable = ['step_number', 'description', 'recipe_id'];
    public $timestamps = false;

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
