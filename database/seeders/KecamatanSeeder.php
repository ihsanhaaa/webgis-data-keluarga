<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinsi = Provinsi::where('nama_provinsi', 'Kalimantan Barat')->first();

        // Ambil semua Kabupaten di Provinsi Kalimantan Barat (Misalnya Kabupaten Contoh)
        $kabupatens = Kabupaten::where('provinsi_id', $provinsi->id)->get();

        foreach ($kabupatens as $kabupaten) {
            // Buat Kecamatan di setiap Kabupaten
            Kecamatan::create([
                'nama_kecamatan' => 'Kecamatan Contoh di ' . $kabupaten->nama_kabupaten,
                'provinsi_id' => $provinsi->id,
                'kabupaten_id' => $kabupaten->id,
            ]);

            // Tambahkan lebih banyak data kecamatan jika diperlukan
            // ...
        }
    }
}
