<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    use HasFactory;

    // ถ้าตารางชื่อ skin_types อยู่แล้ว จะไม่ต้องระบุก็ได้
    protected $table = 'skin_types';

    // คีย์หลักของตาราง (ของคุณใช้ skin_type_id)
    protected $primaryKey = 'skin_type_id';

    // ถ้าเป็น AUTO_INCREMENT ให้ตั้งค่า 2 บรรทัดนี้ (ส่วนใหญ่ใช่)
    public $incrementing = true;
    protected $keyType = 'int';

    // ไม่มี created_at/updated_at
    public $timestamps = false;

    // ระบุฟิลด์ที่แก้ไขได้ (ปรับตามคอลัมน์จริง)
    protected $fillable = ['name'];

    /** ---------------- Relationships ---------------- */

    // อย่าลืม import คลาสที่เกี่ยวข้อง
    public function users()
    {
        // user.skin_type_id -> skin_types.skin_type_id
        return $this->hasMany(User::class, 'skin_type_id', 'skin_type_id');
    }

    public function products()
    {
        // Pivot: product_skin_types (skin_type_id, product_id)
        return $this->belongsToMany(Product::class, 'product_skin_types', 'skin_type_id', 'product_id');
    }
}
