<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $path = (string) ($this->image_path ?? '');

        // Normalize slashes
        $path = str_replace('\\', '/', $path);

        // If DB accidentally stores full Windows path like:
        // C:/Users/Lenovo/Downloads/Webapp Project/Skinscan/public/product_image/xxx.jpg
        if (Str::contains($path, '/public/product_image/')) {
            $filename = basename($path);
            return asset('product_image/'.$filename);
        }

        // If DB stores only the filename (xxx.jpg)
        if ($path && !Str::contains($path, '/')) {
            return asset('product_image/'.$path);
        }

        // If DB stores relative like ./product_image/xxx.jpg or product_image/xxx.jpg
        if (Str::startsWith($path, ['./', 'product_image/'])) {
            $path = ltrim($path, './');
            return asset($path);
        }

        // If it’s already a full URL, just return it
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Fallback placeholder
        return asset('image/placeholder.png');
    }

    public function ingredients()
    {
        return $this->belongsToMany(
            \App\Models\Ingredient::class,
            'product_ingredients',   // pivot
            'product_id',            // FK on pivot to Product
            'ingredient_id'          // FK on pivot to Ingredient
        );
    }


}
