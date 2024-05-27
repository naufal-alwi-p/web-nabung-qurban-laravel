<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HewanQurban extends Model
{
    use HasFactory;

    protected $table = "hewan_qurban";

    public function pembelianQurban(): HasMany {
        return $this->hasMany(PembelianQurban::class);
    }
}
