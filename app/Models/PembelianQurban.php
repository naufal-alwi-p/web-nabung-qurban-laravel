<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianQurban extends Model
{
    use HasFactory;

    protected $table = 'pembelian_qurban';

    public $timestamps = false;

    protected $fillable = [
        'user_nik',
        'hewan_qurban_id',
        'tipe_angsuran',
        'biaya_per_periode',
        'total_uang',
        'sisa_angsuran',
        'jatuh_tempo',
        'status'
    ];

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
