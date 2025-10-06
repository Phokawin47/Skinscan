<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    protected $table = 'scan_history';
    protected $primaryKey = 'scan_id';
    public $timestamps = true;

    // เพิ่มเพื่อความชัดเจน
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id','skin_type','result_image_path'
    ];

    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function results() { return $this->hasMany(ScanResult::class, 'scan_id'); }
}



