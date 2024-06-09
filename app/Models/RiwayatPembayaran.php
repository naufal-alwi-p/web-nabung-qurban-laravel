<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembayaran';

    public $timestamps = false;

    public function pembelianQurban(): BelongsTo {
        return $this->belongsTo(PembelianQurban::class);
    }

}
