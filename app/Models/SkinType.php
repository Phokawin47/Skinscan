<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    use HasFactory;

    protected $primaryKey = 'skin_type_id';
    public $timestamps = false;

    /**
     * Get the users for this skin type.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'skin_type_id', 'skin_type_id');
    }

    /**
     * The products that are suitable for this skin type.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_skin_types', 'skin_type_id', 'product_id');
    }
}
