<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariRayaIdulAdha extends Model
{
    use HasFactory;

    protected $table = "hari_raya_idul_adha";

    public $timestamps = false;

    protected $primaryKey = "tahun";

    protected $fillable = [
        'tahun',
        'tangga'
    ];
}
