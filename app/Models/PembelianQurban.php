<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianQurban extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pembelian_qurban';

    public $incrementing = false;

    protected $keyType = 'string';

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function hewanQurban(): BelongsTo {
        return $this->belongsTo(HewanQurban::class);
    }

    public function riwayatPembayaran(): HasMany {
        return $this->hasMany(RiwayatPembayaran::class);
    }

}
