<?php

namespace App\Http\Controllers;

use App\Exports\KartuKeluargaExport;
use App\Models\AnggotaKeluarga;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DataKeluargaController extends Controller
{
    public function getKartuKeluargaByOsmId($osm_id)
    {
        // $kartuKeluarga = KartuKeluarga::where('osm_id', $osm_id)->first();
        // $kepalaKeluarga = $kartuKeluarga->anggotaKeluargas()->where('status_hubungan_keluarga', 'Kepala Keluarga')->get();

        $kartuKeluarga = KartuKeluarga::where('osm_id', $osm_id)
        ->with(['anggotaKeluargas' => function ($query) {
            $query->where('status_hubungan_keluarga', 'Kepala Keluarga');
        }])
        ->first();

        // dd($kartuKeluarga);

        return response()->json($kartuKeluarga);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        // dd($id);
        $desas = Desa::all();
        $kecamatans = Kecamatan::all();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all();

        $kartuKeluarga = KartuKeluarga::where('osm_id', $id)->first();

        $kepalaKeluarga = AnggotaKeluarga::where('osm_id', $id)
                                     ->where('status_hubungan_keluarga', 'Kepala Keluarga')
                                     ->first();

        $anggotaKeluargas = AnggotaKeluarga::where('osm_id', $id)->get();

        // dd($kartuKeluarga);

        return view('data-keluarga.create', compact('desas', 'kecamatans', 'provinsis', 'kabupatens', 'id', 'anggotaKeluargas', 'kartuKeluarga', 'kepalaKeluarga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'osm_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'no_kk' => 'required',
            'alamat' => 'required',
            'rtrw' => 'required',
            'kode_pos' => 'required',
            'foto_rumah' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        $input = $request->all();

        // Upload foto rumah
        if ($request->hasFile('foto_rumah')) {
            $image = $request->file('foto_rumah');
            $extension = $image->getClientOriginalExtension();
            $imageName = $request->osm_id . '_' . uniqid() . '.' . $extension;
            $image->move(public_path('foto-rumah'), $imageName);
            $input['foto_rumah'] = $imageName;
        }

        $input['user_id'] = Auth::user()->id;

        KartuKeluarga::create($input);

        return redirect()->back()->with('success', 'Data kartu keluarga berhasil ditambahkan');
    }


    public function tambahAnggotaKeluarga(Request $request)
    {
        // dd($request);

        $request->validate([
            'osm_id' => 'required',
            'nama_lengkap' => 'required|string',
            'nik' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'tingkat_pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'golongan_darah' => 'required',
            'status_perkawinan' => 'required',
            'tanggal_perkawinan' => 'nullable',
            'status_hubungan_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'no_paspor' => 'nullable',
            'no_kitab' => 'nullable',
            'nama_orangtua_ayah' => 'required|string',
            'nama_orangtua_ibu' => 'required|string',
        ]);

        $KartuKeluarga = KartuKeluarga::where('osm_id', $request->osm_id)->first();

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['osm_id'] = $request->osm_id;
        $input['kartu_keluarga_id'] = $KartuKeluarga->id;
        $input['data_ditambahkan'] = Carbon::now();

        AnggotaKeluarga::create($input);

        // dd($KartuKeluarga);

        return redirect()->back()->with('success','Data Anggota keluarga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kartuKeluarga = KartuKeluarga::where('osm_id', $id)->first();
        // $kartuKeluarga = KartuKeluarga::find($id);

        $anggotaKeluargas = AnggotaKeluarga::where('osm_id', $id)->get();
        // dd($kartuKeluarga);

        $kepalaKeluarga = AnggotaKeluarga::where('osm_id', $id)
                                     ->where('status_hubungan_keluarga', 'Kepala Keluarga')
                                     ->first();

        return view('data-keluarga.show', compact('id', 'anggotaKeluargas', 'kartuKeluarga', 'kepalaKeluarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editKK(Request $request, string $id)
    {
        // dd($id);

        $request->validate([
            'osm_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'no_kk' => 'required',
            'alamat' => 'required',
            'rtrw' => 'required',
            'kode_pos' => 'required',
            'foto_rumah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        $input = $request->all();

        $kartuKeluarga = KartuKeluarga::find($id);

        // Hapus foto lama jika ada
        if ($request->hasFile('foto_rumah') && $kartuKeluarga->foto_rumah) {
            // Hapus foto lama dari direktori
            unlink(public_path('foto-rumah') . '/' . $kartuKeluarga->foto_rumah);
            $kartuKeluarga->foto_rumah = null;
        }

        // Upload foto rumah baru jika ada
        if ($request->hasFile('foto_rumah')) {
            $image = $request->file('foto_rumah');
            $extension = $image->getClientOriginalExtension();
            $imageName = $request->osm_id . '_' . uniqid() . '.' . $extension;
            $image->move(public_path('foto-rumah'), $imageName);
            $input['foto_rumah'] = $imageName;
        }

        $kartuKeluarga->update($input);

        return redirect()->back()->with('success', 'Data kartu keluarga berhasil diubah');
    }

    public function editAnggotaKeluarga(Request $request, string $id)
    {
        // dd($id);

        $request->validate([
            'osm_id' => 'required',
            'nama_lengkap' => 'required|string',
            'nik' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'tingkat_pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'golongan_darah' => 'required',
            'status_perkawinan' => 'required',
            'tanggal_perkawinan' => 'nullable',
            'status_hubungan_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'no_paspor' => 'nullable',
            'no_kitab' => 'nullable',
            'nama_orangtua_ayah' => 'required|string',
            'nama_orangtua_ibu' => 'required|string',
        ]);

        $kartuKeluarga = AnggotaKeluarga::find($id);

        $KartuKeluarga = KartuKeluarga::where('osm_id', $request->osm_id)->first();

        // dd($KartuKeluarga);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['osm_id'] = $request->osm_id;
        $input['kartu_keluarga_id'] = $KartuKeluarga->id;
        $input['data_ditambahkan'] = Carbon::now();

        $kartuKeluarga->update($input);

        return redirect()->back()->with('success', 'Data anggota keluarga berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export()
    {
        return Excel::download(new KartuKeluargaExport, 'laporan-kartu-keluarga.xlsx');
    }
}
