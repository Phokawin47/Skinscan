<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'ingredient_id';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'product_ingredients',
            'ingredient_id',
            'product_id'
        );
    }
}
