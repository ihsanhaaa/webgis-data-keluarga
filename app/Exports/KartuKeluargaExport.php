<?php

namespace App\Exports;

use App\Models\KartuKeluarga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KartuKeluargaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KartuKeluarga::select(
            'no_kk',
            'desas.nama_desa',
            'kecamatans.nama_kecamatan'
        )
        ->leftJoin('desas', 'kartu_keluargas.desa_id', '=', 'desas.id')
        ->leftJoin('kecamatans', 'kartu_keluargas.kecamatan_id', '=', 'kecamatans.id')
        ->leftJoin('anggota_keluargas', 'kartu_keluargas.id', '=', 'anggota_keluargas.kartu_keluarga_id')
        ->groupBy('kartu_keluargas.id', 'no_kk', 'desas.nama_desa', 'kecamatans.nama_kecamatan')
        ->selectRaw('COUNT(anggota_keluargas.id) as jumlah_anggota')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Nomor KK',
            'Desa',
            'Kecamatan',
            'Jumlah Anggota Keluarga'
        ];
    }
}
