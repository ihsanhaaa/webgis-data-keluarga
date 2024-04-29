<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kecamatans = Kecamatan::all();
        $labelsKecamatan = [];
        $jumlahKecamatan = [];

        foreach ($kecamatans as $kecamatan) {
            $jumlah_kartu_keluarga = KartuKeluarga::where('kecamatan_id', $kecamatan->id)->count();
            $labelsKecamatan[] = $kecamatan->nama_kecamatan;
            $jumlahKecamatan[] = $jumlah_kartu_keluarga;
        }

        $kecamatanDesa = Kecamatan::withCount('desas')->get();

        $labelsDesa = $kecamatanDesa->pluck('nama_kecamatan');
        $jumlahDesa = $kecamatanDesa->pluck('desas_count');

        return view('home', compact('labelsKecamatan', 'jumlahKecamatan', 'labelsDesa', 'jumlahDesa'));
    }
}
