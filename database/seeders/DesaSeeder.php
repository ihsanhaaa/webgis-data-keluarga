<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
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
            // Ambil semua Kecamatan di Kabupaten Contoh
            $kecamatans = Kecamatan::where('kabupaten_id', $kabupaten->id)->get();

            foreach ($kecamatans as $kecamatan) {
                // Buat Desa di setiap Kecamatan
                Desa::create([
                    'nama_desa' => 'Desa Contoh di ' . $kecamatan->nama_kecamatan,
                    'provinsi_id' => $provinsi->id,
                    'kabupaten_id' => $kabupaten->id,
                    'kecamatan_id' => $kecamatan->id,
                ]);

                // Tambahkan lebih banyak data desa jika diperlukan
                // ...
            }
        }
    }
}
