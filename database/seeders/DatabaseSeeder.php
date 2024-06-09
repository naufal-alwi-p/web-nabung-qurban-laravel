<?php

namespace Database\Seeders;

use App\Models\HariRayaIdulAdha;
use App\Models\HewanQurban;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tahun = 2024;
        $tanggal = Carbon::parse("2024-06-16");

        $hari_raya_idul_adha = [];

        for ($i = 1; $i <= 10; $i++) {
            if ($i !== 1) {
                if ($tahun % 2 === 0) {
                    $tanggal->addDays((354));
                } else {
                    $tanggal->addDays(355);
                }
            }

            $data = [
                'tahun' => $tahun++,
                'tanggal' => $tanggal->format('Y-m-d')
            ];

            array_push($hari_raya_idul_adha, $data);
        }

        HewanQurban::factory()->createMany([
            [
                'nama' => 'Sapi',
                'harga' => 20000000
            ],
            [
                'nama' => 'Kambing',
                'harga' => 3500000
            ]
        ]);

        HariRayaIdulAdha::factory()->createMany($hari_raya_idul_adha);
    }
}
