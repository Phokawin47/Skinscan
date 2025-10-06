<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $primaryKey = 'brand_id';
     
    // **ต้องมีบรรทัดนี้เพื่ออนุญาต Mass Assignment สำหรับการสร้างแบรนด์ใหม่**
    protected $fillable = ['brand_name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }
}