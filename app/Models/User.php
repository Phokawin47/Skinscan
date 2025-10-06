<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

// ⬇️ import โมเดลที่ใช้งาน
use App\Models\Role;
use App\Models\SkinType;
use App\Models\ScanHistory;
use App\Models\Product;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    /** @var array<int, string> */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        // fields for onboarding
        'gender',
        'age',
        'is_sensitive_skin',
        'allergies',
        'role_id',
        'skin_type_id',
    ];

    /** @var array<int, string> */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /** @var array<int, string> */
    protected $appends = [
        'profile_photo_url',
        'name', // ให้เข้ากับ Jetstream ที่อ้าง $user->name
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'age'               => 'integer',
            'is_sensitive_skin' => 'boolean',
        ];
    }

    /* ================== Accessors & Helpers ================== */

    // ให้ Jetstream ใช้ $user->name ได้ แม้เราจะแยก first/last
    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? '')) ?: ($this->username ?? '');
    }

    // ใช้ใน middleware เพื่อเช็กว่า profile กรอกครบหรือยัง
    public function isProfileComplete(): bool
    {
        $required = ['gender', 'age', 'skin_type_id']; // ปรับตามที่ต้องการบังคับ
        foreach ($required as $f) {
            if (empty($this->{$f})) return false;
        }
        return true;
    }

    /** เช็คบทบาทของผู้ใช้ (รองรับหลายค่า) */
    public function hasRole(string|array $roles): bool
    {
        $current = optional($this->role)->role_name; // 'general' | 'product_manager' | 'admin'
        return is_array($roles) ? in_array($current, $roles, true) : $current === $roles;
    }

    /** ช่วยเรียกสั้น ๆ */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /* ================== Relationships ================== */

    public function role()
    {
        // ระบุ owner key ให้ตรงกับตาราง roles (PK = role_id)
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function skinType()
    {
        // ระบุ owner key ให้ตรงกับตาราง skin_types (PK = skin_type_id)
        return $this->belongsTo(SkinType::class, 'skin_type_id', 'skin_type_id');
    }

    public function scanHistories()
    {
        return $this->hasMany(ScanHistory::class, 'user_id', 'id');
    }

    public function addedProducts()
    {
        return $this->hasMany(Product::class, 'added_by_user_id', 'id');
    }
}
