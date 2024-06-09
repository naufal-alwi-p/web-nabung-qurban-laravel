<?php

use App\Models\HewanQurban;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_qurban', function (Blueprint $table) {
            $table->id();
            $table->char('user_nik', 16);
            $table->foreignIdFor(HewanQurban::class);
            $table->enum('tipe_angsuran', ['per Minggu', 'per Bulan']);
            $table->integer('biaya_per_periode', unsigned: true);
            $table->integer('total_uang', unsigned: true);
            $table->integer('sisa_angsuran');
            $table->date('jatuh_tempo');
            $table->enum('status', ['Berhasil', 'Sedang Angsuran', 'Refund']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_qurban');
    }
};
