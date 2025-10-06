<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; // **ตรวจสอบว่ามี use Str แล้ว**

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'image_path',
        'usage_details',
        'suitability_info',
        'brand_id',
        'category_id',
        'added_by_user_id',
    ];

    protected $appends = ['image_url'];

    /** Accessors **/
    public function getImageUrlAttribute()
    {
        $path = (string) ($this->image_path ?? '');
        $path = str_replace('\\', '/', $path); // Normalize path separators for consistency

        // **ปรับปรุง logic การสร้าง URL ของรูปภาพ**

        // 1. ตรวจสอบว่า path เริ่มต้นด้วย './product_image/' (รูปแบบจากฐานข้อมูลของคุณ)
        if (Str::startsWith($path, './product_image/')) {
            // ลบ './' ออก แล้วใช้ asset() เพื่อสร้าง URL สาธารณะ
            $cleanedPath = ltrim($path, './'); // เช่น 'product_image/B3-01.jpg'
            return asset($cleanedPath); // เช่น 'http://localhost/product_image/B3-01.jpg'
        }
        // 2. ตรวจสอบว่า path เป็นรูปแบบที่มาจากการใช้ storage (เช่น 'products/ชื่อไฟล์.jpg')
        //    ต้องแน่ใจว่าได้รัน `php artisan storage:link` แล้ว
        if (Str::startsWith($path, 'products/')) {
            return asset('storage/' . $path); // เช่น 'http://localhost/storage/products/xxxxxxxx.jpg'
        }
        // 3. หากเป็น URL เต็ม (http:// หรือ https://)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        // 4. หากเป็นรูปแบบเก่าที่เคยมี /public/product_image/ อยู่ใน path (ไม่ควรมีแล้วถ้าใช้ store('products', 'public'))
        //    ถ้ายังมี Path แบบนี้อยู่ และต้องการรองรับ สามารถคงส่วนนี้ไว้ได้ แต่ควรจัดการให้ Path สะอาดขึ้น
        if (Str::contains($path, '/public/product_image/')) {
            $filename = basename($path);
            return asset('product_image/' . $filename);
        }
        if ($path && !Str::contains($path, '/') && !Str::contains($path, '.')) { // ตรวจสอบว่า path เป็นแค่ชื่อไฟล์โดดๆ (ไม่ค่อยแนะนำ)
            return asset('product_image/' . $path);
        }


        // คืนค่ารูป placeholder หากไม่มีรูปภาพที่ถูกต้องหรือ path ไม่ตรงกับรูปแบบที่รู้จัก
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