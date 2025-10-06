<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = ['category_name']; 
    /**
     * Get the products for this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
