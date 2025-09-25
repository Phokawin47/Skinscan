<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    use HasFactory;

    protected $table = 'scan_history';
    protected $primaryKey = 'scan_id';
    public $timestamps = false; // We use scan_timestamp instead

    /**
     * Get the user that owns the scan history.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The acne types detected in this scan.
     */
    public function detectedAcnes()
    {
        return $this->belongsToMany(AcneType::class, 'scan_results', 'scan_id', 'acne_type_id');
    }
}
