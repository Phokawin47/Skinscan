<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcneType extends Model
{
    protected $table = 'acne_types';
    protected $primaryKey = 'acne_type_id';
    protected $fillable = ['acne_type_name'];
}

