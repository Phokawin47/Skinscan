<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcneType extends Model
{
    use HasFactory;

    protected $primaryKey = 'acne_type_id';
    public $timestamps = false;

    /**
     * The scan histories that detected this acne type.
     */
    public function scanHistories()
    {
        return $this->belongsToMany(ScanHistory::class, 'scan_results', 'acne_type_id', 'scan_id');
    }
}
