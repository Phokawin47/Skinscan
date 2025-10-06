<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // ตารางและคีย์ (ช่วยกัน error เวลา query/relationship)
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    public $incrementing = true;   // ถ้าเป็น AUTO_INCREMENT
    protected $keyType = 'int';
    public $timestamps = false;

    // ระบุฟิลด์ที่แก้ไขได้ (ตามคอลัมน์จริง)
    protected $fillable = ['role_name'];

    // ชื่อ role แบบคงที่ ใช้ซ้ำได้ทุกที่
    public const GENERAL         = 'general';
    public const PRODUCT_MANAGER = 'product_manager';
    public const ADMIN           = 'admin';

    /** ความสัมพันธ์: role -> users */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    /** scope: ค้นหาตามชื่อ role */
    public function scopeNamed($query, string $name)
    {
        return $query->where('role_name', $name);
    }

    /** helper: ดึง id จากชื่อ role */
    public static function idOf(string $name): ?int
    {
        return static::where('role_name', $name)->value('role_id');
    }
}
