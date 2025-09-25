<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    /**
     * Get the brand that the product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }

    /**
     * Get the user who added the product.
     */
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by_user_id', 'id');
    }

    /**
     * The ingredients that belong to the product.
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients', 'product_id', 'ingredient_id');
    }

    /**
     * The skin types that the product is suitable for.
     */
    public function skinTypes()
    {
        return $this->belongsToMany(SkinType::class, 'product_skin_types', 'product_id', 'skin_type_id');
    }
}
