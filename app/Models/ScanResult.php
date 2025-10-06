<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanResult extends Model
{
    protected $table = 'scan_results';
    protected $fillable = [
        'scan_id','acne_type_id',
    ];

    public function scan() { return $this->belongsTo(ScanHistory::class, 'scan_id'); }
    public function acneType() { return $this->belongsTo(AcneType::class, 'acne_type_id'); }
}
