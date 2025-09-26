<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    // If your PK is integer & auto-increment, these are fine (default); adjust if needed:
    public $incrementing = true;
    protected $keyType = 'int';

    // If your table does NOT have created_at/updated_at, uncomment the next line:
    // public $timestamps = false;

    protected $fillable = [
        'product_name',
        'image_path',
        'usage_details',
        'suitability_info',
        // include FKs if you mass-assign them:
        'brand_id',
        'category_id',
        'added_by_user_id',
    ];

    protected $appends = ['image_url'];

    /** Accessors **/
    public function getImageUrlAttribute()
    {
        $path = (string) ($this->image_path ?? '');
        $path = str_replace('\\', '/', $path);

        if (Str::contains($path, '/public/product_image/')) {
            $filename = basename($path);
            return asset('product_image/' . $filename);
        }
        if ($path && !Str::contains($path, '/')) {
            return asset('product_image/' . $path);
        }
        if (Str::startsWith($path, ['./', 'product_image/'])) {
            $path = ltrim($path, './');
            return asset($path);
        }
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
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
            'product_ingredients',
            'product_id',
            'ingredient_id'
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
