<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $appends = ['image_url'];

    /** Accessors **/
    public function getImageUrlAttribute()
    {
        $path = (string) ($this->image_path ?? '');
        $path = str_replace('\\', '/', $path);

        // Full Windows-like path containing /public/product_image/
        if (Str::contains($path, '/public/product_image/')) {
            $filename = basename($path);
            return asset('product_image/' . $filename);
        }

        // Only filename (e.g., xxx.jpg)
        if ($path && !Str::contains($path, '/')) {
            return asset('product_image/' . $path);
        }

        // Relative like ./product_image/xxx.jpg or product_image/xxx.jpg
        if (Str::startsWith($path, ['./', 'product_image/'])) {
            $path = ltrim($path, './');
            return asset($path);
        }

        // Already a full URL
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Fallback
        return asset('image/placeholder.png');
    }

    /** Relationships **/
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }

    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by_user_id', 'id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(
            Ingredient::class,
            'product_ingredients', // pivot
            'product_id',          // FK to products
            'ingredient_id'        // FK to ingredients
        );
    }

    public function skinTypes()
    {
        return $this->belongsToMany(
            SkinType::class,
            'product_skin_types',
            'product_id',
            'skin_type_id'
        );
    }

    
}
