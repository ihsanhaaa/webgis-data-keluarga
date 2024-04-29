<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinsi = Provinsi::where('nama_provinsi', 'Kalimantan Barat')->first();

        // Buat Kabupaten
        $kabupaten = Kabupaten::create([
            'nama_kabupaten' => 'Kabupaten Contoh',
            'provinsi_id' => $provinsi->id,
        ]);
    }
}
