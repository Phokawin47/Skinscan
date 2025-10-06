<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredients';
    protected $primaryKey = 'ingredient_id';
    public $timestamps = false;
    protected $fillable = ['ingredient_name'];


    /**
     * The products that contain this ingredient.
     */
    public function products()
    {
        return $this->belongsToMany(
            Product::class,              // Related model
            'product_ingredients',       // Pivot table
            'ingredient_id',             // Foreign key on pivot (Ingredient)
            'product_id'                 // Foreign key on pivot (Product)
        );
    }
}
