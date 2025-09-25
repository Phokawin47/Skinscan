<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $primaryKey = 'ingredient_id';
    public $timestamps = false;

    /**
     * The products that contain this ingredient.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients', 'ingredient_id', 'product_id');
    }
}
