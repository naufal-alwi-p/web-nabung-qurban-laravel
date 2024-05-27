<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPembayaran extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'riwayat_pembayaran';

    public $incrementing = false;

    protected $keyType = 'string';

    public function pembelianQurban(): BelongsTo {
        return $this->belongsTo(PembelianQurban::class);
    }

}
