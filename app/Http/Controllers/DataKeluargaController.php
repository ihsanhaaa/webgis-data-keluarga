<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class DataKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('data-keluarga.index');
    }

    public function getKartuKeluargaByOsmId($osm_id) 
    {
        $kartuKeluarga = KartuKeluarga::where('osm_id', $osm_id)->first();
        // dd($kartuKeluarga);

        return response()->json($kartuKeluarga);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data-keluarga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
