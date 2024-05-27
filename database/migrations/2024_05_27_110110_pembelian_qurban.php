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
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(HewanQurban::class);
            $table->enum('tipe_angsuran', ['per Minggu', 'per Bulan']);
            $table->integer('biaya_per_bulan', unsigned: true);
            $table->integer('banyak_angsuran');
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