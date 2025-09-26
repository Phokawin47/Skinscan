<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Product extends Model
{
    use HasFactory, SoftDeletes; // ใช้งาน SoftDeletes

    public $primaryKey = 'product_id'; // <--- เพิ่มบรรทัดนี้

     protected $fillable = [
        'product_name',
        'image_path',
        'usage_details',
        'suitability_info', // <-- ฟิลด์นี้อาจจะยังต้องใช้ในหน้า Edit/Update
        // เราไม่จำเป็นต้องใส่ ingredients, type, skin_type, category, description ที่นี่อีกแล้ว
    ];

    
}
