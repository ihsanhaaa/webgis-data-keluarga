@extends('layouts.app')

@section('content')
@push('css-plugins')
<link rel="stylesheet" href="{{ asset('style.css') }}" />
<link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
@endpush

@include('components.navbar')

<!-- Main -->
<main>
    <!-- Hero-Section -->
    <section id="hero" class="mt-[84px] mb-8 bg-[#baffae]">
        <h1 class="text-[36px] font-bold mb-2">
            <p class="text-left text-center">Detail Data Keluarga</p>
        </h1>
    </section>

    @if ($message = Session::get('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-5" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('alert'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-5" role="alert">
            <p class="font-bold">Alert</p>
            <p>{{ $message }}</p>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-5" role="alert">
            @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong><br>
            @endforeach
        </div>
    @endif

    <a href="/tambah-data/{{ $id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Data KK</a>


    <!-- This is an example component -->
    <div class="column-2">
        <div>
            @if($kartuKeluarga)
            <img src="{{ asset('foto-rumah/'. $kartuKeluarga->foto_rumah) }}" class="d-block w-100 mb-3" alt="...">
            @else
            <div class="alert alert-primary text-center" role="alert">
                Belum ada foto!
            </div>
            @endif
        </div>

        <div>

            <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                <ul class="flex flex-wrap -mb-px" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 dark:text-gray-400 dark:hover:text-gray-300" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Data Kartu Keluarga</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center border-transparent border-b-2 dark:text-gray-400 dark:hover:text-gray-300 active" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Anggota Keluarga</button>
                    </li>
                </ul>
            </div>
            <div id="myTabContent">
                <div class="bg-white p-4 rounded-lg hidden" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if($kartuKeluarga)
                    <form action="{{ route('editKK', $kartuKeluarga->id) }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="osm_id" class="form-label">ID OSM</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="osmInput" name="osm_id" value="{{ $id }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="foto_rumah" class="form-label">Foto Rumah</label>
                            <input type="file" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="foto_rumah" name="foto_rumah">
                        </div>

                        <div class="mb-3">
                            <label for="no_kk" class="form-label">No KK</label>
                            <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="no_kk" name="no_kk" value="{{ old('no_kk', $kartuKeluarga ? $kartuKeluarga->no_kk : '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="kepala_keluarga" class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="kepala_keluarga" name="kepala_keluarga" value="{{ isset($kepalaKeluarga->nama_lengkap) ? $kepalaKeluarga->nama_lengkap : '' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="alamat" name="alamat" value="{{ old('alamat', $kartuKeluarga ? $kartuKeluarga->alamat : '') }}" required>
                        </div>


                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rtrw" class="form-label">RT/RW</label>
                                    <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="rtrw" name="rtrw" value="{{ old('rtrw', $kartuKeluarga ? $kartuKeluarga->rtrw : '') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $kartuKeluarga ? $kartuKeluarga->kode_pos : '') }}" required>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                    </form>
                    @else
                    <form action="{{ route('data-keluarga.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="osm_id" class="form-label">ID OSM</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="osmInput" name="osm_id" value="{{ $id }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="foto_rumah" class="form-label">Foto Rumah</label>
                            <input type="file" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="foto_rumah" name="foto_rumah" required>
                        </div>

                        <div class="mb-3">
                            <label for="no_kk" class="form-label">No KK</label>
                            <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="no_kk" name="no_kk" value="{{ old('no_kk', $kartuKeluarga ? $kartuKeluarga->no_kk : '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="kepala_keluarga" class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="kepala_keluarga" name="kepala_keluarga" value="{{ isset($kepalaKeluarga->nama_lengkap) ? $kepalaKeluarga->nama_lengkap : '' }}" disabled>
                        </div>


                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="alamat" name="alamat" value="{{ old('alamat', $kartuKeluarga ? $kartuKeluarga->alamat : '') }}" required>
                        </div>


                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rtrw" class="form-label">RT/RW</label>
                                    <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="rtrw" name="rtrw" value="{{ old('rtrw', $kartuKeluarga ? $kartuKeluarga->rtrw : '') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $kartuKeluarga ? $kartuKeluarga->kode_pos : '') }}" required>
                                </div>
                            </div>
                        </div>



                        


                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Data</button>
                    </form>
                    @endif
                </div>
                <div class="bg-white p-4 rounded-lg" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    @if($anggotaKeluargas)
                    @forelse($anggotaKeluargas as $anggotaKeluarga)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('user.png') }}" class="mx-auto mt-4" alt="..." height="50" width="50">
                            <div class="card-body">
                                <h5 class="card-title text-center" style="font-size: 18px;"> {{ $anggotaKeluarga->nama_lengkap }} </h5>
                                <h5 class="card-title text-center" style="font-size: 15px;"> {{ $anggotaKeluarga->status_hubungan_keluarga }} </h5>
                                <div x-data="{ editAnggotaKeluarga: false }">
                                    <button @click="editAnggotaKeluarga =!editAnggotaKeluarga" class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>

                                        <span>Edit Anggota Keluarga</span>
                                    </button>

                                    <div x-show="editAnggotaKeluarga" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                            <div x-cloak @click="editAnggotaKeluarga = false" x-show="editAnggotaKeluarga" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                            <div x-cloak x-show="editAnggotaKeluarga" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                <div class="flex items-center justify-between space-x-4">
                                                    <h1 class="text-xl font-medium text-gray-800 ">Edit Anggota Keluarga</h1>

                                                    <button @click="editAnggotaKeluarga = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form action="{{ route('editAnggotaKeluarga', $anggotaKeluarga->id) }}" method="POST" class="needs-validation">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" class="form-control" name="osm_id" value="{{ $id }}">

                                                    <div class="mb-3">
                                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $anggotaKeluarga->nama_lengkap) }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nik" class="form-label">NIK</label>
                                                        <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="nik" name="nik" value="{{ old('nik', $anggotaKeluarga->nik) }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                        <div class="form-check">
                                                            <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="radio" name="jenis_kelamin" id="laki-laki" value="laki-laki" {{ old('jenis_kelamin', $anggotaKeluarga->jenis_kelamin) == 'laki-laki' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="laki-laki">
                                                                Laki-laki
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin', $anggotaKeluarga->jenis_kelamin) == 'perempuan' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="perempuan">
                                                                Perempuan
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                                <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $anggotaKeluarga->tempat_lahir) }}" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                                <input type="date" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggotaKeluarga->tanggal_lahir) }}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="agama" class="form-label">Agama</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="agama" name="agama" required>
                                                            <option value="Islam" {{ old('agama', $anggotaKeluarga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                            <option value="Kristen" {{ old('agama', $anggotaKeluarga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                            <option value="Katholik" {{ old('agama', $anggotaKeluarga->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                                            <option value="Hindu" {{ old('agama', $anggotaKeluarga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                            <option value="Budha" {{ old('agama', $anggotaKeluarga->agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                                                            <option value="Khonghucu" {{ old('agama', $anggotaKeluarga->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="tingkat_pendidikan" class="form-label">Pendidikan</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="tingkat_pendidikan" name="tingkat_pendidikan" required>
                                                            <option value="Tidak / Belum Sekolah" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Tidak / Belum Sekolah' ? 'selected' : '' }}>Tidak / Belum Sekolah</option>
                                                            <option value="Belum Tamat SD / Sederajat" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Belum Tamat SD / Sederajat' ? 'selected' : '' }}>Belum Tamat SD / Sederajat</option>
                                                            <option value="Tamat SD / Sederajat" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Tamat SD / Sederajat' ? 'selected' : '' }}>Tamat SD / Sederajat</option>
                                                            <option value="SLTP / Sederajat" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'SLTP / Sederajat' ? 'selected' : '' }}>SLTP / Sederajat</option>
                                                            <option value="SLTA / Sederajat" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'SLTA / Sederajat' ? 'selected' : '' }}>SLTA / Sederajat</option>
                                                            <option value="Diploma I / II" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Diploma I / II' ? 'selected' : '' }}>Diploma I / II</option>
                                                            <option value="Akademi / Diploma III / Sarjana Muda" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Akademi / Diploma III / Sarjana Muda' ? 'selected' : '' }}>Akademi / Diploma III / Sarjana Muda</option>
                                                            <option value="Diploma IV / Strata I" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Diploma IV / Strata I' ? 'selected' : '' }}>Diploma IV / Strata I</option>
                                                            <option value="Strata II" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Strata II' ? 'selected' : '' }}>Strata II</option>
                                                            <option value="Strata III" {{ old('tingkat_pendidikan', $anggotaKeluarga->tingkat_pendidikan) == 'Strata III' ? 'selected' : '' }}>Strata III</option>
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="jenis_pekerjaan" class="form-label">Status Pekerjaan</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                                                            <option value="Belum / Tidak Bekerja" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Belum / Tidak Bekerja' ? 'selected' : '' }}>Belum / Tidak Bekerja</option>
                                                            <option value="Mengurus Rumah Tangga" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Mengurus Rumah Tangga' ? 'selected' : '' }}>Mengurus Rumah Tangga</option>
                                                            <option value="Pelajar / Mahasiswa" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pelajar / Mahasiswa' ? 'selected' : '' }}>Pelajar / Mahasiswa</option>
                                                            <option value="Pensiunan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                                            <option value="Pegawai Negeri Sipil (PNS)" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pegawai Negeri Sipil (PNS)' ? 'selected' : '' }}>Pegawai Negeri Sipil (PNS)</option>
                                                            <option value="Tentara Nasional Indonesia (TNI)" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tentara Nasional Indonesia (TNI)' ? 'selected' : '' }}>Tentara Nasional Indonesia (TNI)</option>
                                                            <option value="Kepolisian RI (POLRI)" {{ old('jenis_pekerjaan') == 'Kepolisian RI (POLRI)' ? 'selected' : '' }}>Kepolisian RI (POLRI)</option>
                                                            <option value="Perdagangan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                                                            <option value="Petani / Pekebun" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                                            <option value="Peternak" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                                            <option value="Nelayan/Perikanan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Nelayan/Perikanan' ? 'selected' : '' }}>Nelayan/Perikanan</option>
                                                            <option value="Industri" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Industri' ? 'selected' : '' }}>Industri</option>
                                                            <option value="Konstruksi" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Konstruksi' ? 'selected' : '' }}>Konstruksi</option>
                                                            <option value="Transportasi" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                                            <option value="Karyawan Swasta" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                                            <option value="Karyawan BUMN" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Karyawan BUMN' ? 'selected' : '' }}>Karyawan BUMN</option>
                                                            <option value="Karyawan BUMD" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Karyawan BUMD' ? 'selected' : '' }}>Karyawan BUMD</option>
                                                            <option value="Karyawan Honorer" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Karyawan Honorer' ? 'selected' : '' }}>Karyawan Honorer</option>
                                                            <option value="Buruh Harian Lepas" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Buruh Harian Lepas' ? 'selected' : '' }}>Buruh Harian Lepas</option>
                                                            <option value="Buruh Tani / Perkebunan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Buruh Tani / Perkebunan' ? 'selected' : '' }}>Buruh Tani / Perkebunan</option>
                                                            <option value="Buruh Nelayan/Perikanan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Buruh Nelayan/Perikanan' ? 'selected' : '' }}>Buruh Nelayan/Perikanan</option>
                                                            <option value="Buruh Peternakan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Buruh Peternakan' ? 'selected' : '' }}>Buruh Peternakan</option>
                                                            <option value="Pembantu Rumah Tangga" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pembantu Rumah Tangga' ? 'selected' : '' }}>Pembantu Rumah Tangga</option>
                                                            <option value="Tukang Cukur" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Cukur' ? 'selected' : '' }}>Tukang Cukur</option>
                                                            <option value="Tukang Listrik" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Listrik' ? 'selected' : '' }}>Tukang Listrik</option>
                                                            <option value="Tukang Batu" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Batu' ? 'selected' : '' }}>Tukang Batu</option>
                                                            <option value="Tukang Kayu" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Kayu' ? 'selected' : '' }}>Tukang Kayu</option>
                                                            <option value="Tukang Sol Sepatu" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Sol Sepatu' ? 'selected' : '' }}>Tukang Sol Sepatu</option>
                                                            <option value="Tukang Las/Pandai Besi" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Las/Pandai Besi' ? 'selected' : '' }}>Tukang Las/Pandai Besi</option>
                                                            <option value="Tukang Jahit" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Jahit' ? 'selected' : '' }}>Tukang Jahit</option>
                                                            <option value="Tukang Gigi" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tukang Gigi' ? 'selected' : '' }}>Tukang Gigi</option>
                                                            <option value="Penata Rias" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Penata Rias' ? 'selected' : '' }}>Penata Rias</option>
                                                            <option value="Penata Busana" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Penata Busana' ? 'selected' : '' }}>Penata Busana</option>
                                                            <option value="Mekanik" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Mekanik' ? 'selected' : '' }}>Mekanik</option>
                                                            <option value="Seniman" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Seniman' ? 'selected' : '' }}>Seniman</option>
                                                            <option value="Tabib" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Tabib' ? 'selected' : '' }}>Tabib</option>
                                                            <option value="Paraji" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Paraji' ? 'selected' : '' }}>Paraji</option>
                                                            <option value="Perancang Busana" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Perancang Busana' ? 'selected' : '' }}>Perancang Busana</option>
                                                            <option value="Penterjemah" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Penterjemah' ? 'selected' : '' }}>Penterjemah</option>
                                                            <option value="Imam Masjid" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Imam Masjid' ? 'selected' : '' }}>Imam Masjid</option>
                                                            <option value="Pendeta" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pendeta' ? 'selected' : '' }}>Pendeta</option>
                                                            <option value="Pator" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Pator' ? 'selected' : '' }}>Pator</option>
                                                            <option value="Wartawan" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Wartawan' ? 'selected' : '' }}>Wartawan</option>
                                                            <option value="Ustadz / Mubaligh" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Ustadz / Mubaligh' ? 'selected' : '' }}>Ustadz / Mubaligh</option>
                                                            <option value="Juru Masak" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Juru Masak' ? 'selected' : '' }}>Juru Masak</option>
                                                            <option value="Promotor Acara" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Promotor Acara' ? 'selected' : '' }}>Promotor Acara</option>
                                                            <option value="Anggota DPR-RI" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota DPR-RI' ? 'selected' : '' }}>Anggota DPR-RI</option>
                                                            <option value="Anggota DPD" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota DPD' ? 'selected' : '' }}>Anggota DPD</option>
                                                            <option value="Anggota BPK" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota BPK' ? 'selected' : '' }}>Anggota BPK</option>
                                                            <option value="Presiden" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Presiden' ? 'selected' : '' }}>Presiden</option>
                                                            <option value="Wakil Presiden" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Wakil Presiden' ? 'selected' : '' }}>Wakil Presiden</option>
                                                            <option value="Anggota Mahkamah Konstitusi" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota Mahkamah Konstitusi' ? 'selected' : '' }}>Anggota Mahkamah Konstitusi</option>
                                                            <option value="Anggota Kabinet Kementrian" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota Kabinet Kementrian' ? 'selected' : '' }}>Anggota Kabinet Kementrian</option>
                                                            <option value="Duta Besar" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Duta Besar' ? 'selected' : '' }}>Duta Besar</option>
                                                            <option value="Gubernur" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Gubernur' ? 'selected' : '' }}>Gubernur</option>
                                                            <option value="Wakil Gubernur" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Wakil Gubernur' ? 'selected' : '' }}>Wakil Gubernur</option>
                                                            <option value="Bupati" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Bupati' ? 'selected' : '' }}>Bupati</option>
                                                            <option value="Wakil Bupati" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Wakil Bupati' ? 'selected' : '' }}>Wakil Bupati</option>
                                                            <option value="Walikota" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Walikota' ? 'selected' : '' }}>Walikota</option>
                                                            <option value="Wakil Walikota" {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Wakil Walikota' ? 'selected' : '' }}>Wakil Walikota</option>
                                                            <option value="Anggota DPRP Prop." {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota DPRP Prop.' ? 'selected' : '' }}>Anggota DPRP Prop.</option>
                                                            <option value="Anggota DPRP Kab." {{ old('jenis_pekerjaan', $anggotaKeluarga->jenis_pekerjaan) == 'Anggota DPRP Kab.' ? 'selected' : '' }}>Anggota DPRP Kab.</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="golongan_darah" name="golongan_darah" required>
                                                            <option value="A" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                                            <option value="B" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                                            <option value="AB" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                                            <option value="O" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                                            <option value="A+" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'A+' ? 'selected' : '' }}>A+</option>
                                                            <option value="A-" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'A-' ? 'selected' : '' }}>A-</option>
                                                            <option value="B+" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'B+' ? 'selected' : '' }}>B+</option>
                                                            <option value="B-" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'B-' ? 'selected' : '' }}>B-</option>
                                                            <option value="AB+" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                            <option value="AB-" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                            <option value="O+" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'O+' ? 'selected' : '' }}>O+</option>
                                                            <option value="O-" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'O-' ? 'selected' : '' }}>O-</option>
                                                            <option value="TIDAK TAHU" {{ old('golongan_darah', $anggotaKeluarga->golongan_darah) == 'TIDAK TAHU' ? 'selected' : '' }}>TIDAK TAHU</option>
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                                                <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="status_perkawinan" name="status_perkawinan" required>
                                                                    <option value="Belum Kawin" {{ old('status_perkawinan', $anggotaKeluarga->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                                    <option value="Kawin" {{ old('status_perkawinan', $anggotaKeluarga->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                                                    <option value="Cerai Hidup" {{ old('status_perkawinan', $anggotaKeluarga->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                                    <option value="Cerai Mati" {{ old('status_perkawinan', $anggotaKeluarga->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="tanggal_perkawinan" class="form-label">Tanggal Perkawinan</label>
                                                                <input type="date" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="tanggal_perkawinan" name="tanggal_perkawinan" value="{{ old('tanggal_perkawinan', $anggotaKeluarga->tanggal_perkawinan) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="status_hubungan_keluarga" class="form-label">Status Hubungan Dalam Keluarga</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="status_hubungan_keluarga" name="status_hubungan_keluarga" required>
                                                            <option value="Kepala Keluarga" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                            <option value="Suami" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Suami' ? 'selected' : '' }}>Suami</option>
                                                            <option value="Istri" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                            <option value="Anak" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                            <option value="Menantu" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                                            <option value="Cucu" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                                            <option value="Orangtua" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Orangtua' ? 'selected' : '' }}>Orangtua</option>
                                                            <option value="Mertua" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                                                            <option value="Famili Lain" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                                                            <option value="Pembantu" {{ old('status_hubungan_keluarga', $anggotaKeluarga->status_hubungan_keluarga) == 'Pembantu' ? 'selected' : '' }}>Pembantu</option>
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                                        <select class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="kewarganegaraan" name="kewarganegaraan" required>
                                                            <option value="WNI" {{ old('kewarganegaraan', $anggotaKeluarga->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="no_paspor" class="form-label">No. Paspor</label>
                                                                <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="no_paspor" name="no_paspor" value="{{ old('no_paspor', $anggotaKeluarga->no_paspor) }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="no_kitab" class="form-label">No. KITAP</label>
                                                                <input type="number" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="no_kitab" name="no_kitab" value="{{ old('no_kitab', $anggotaKeluarga->no_kitab) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="nama_orangtua_ayah" class="form-label">Nama Orang Tua Ayah</label>
                                                                <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="nama_orangtua_ayah" name="nama_orangtua_ayah" value="{{ old('nama_orangtua_ayah', $anggotaKeluarga->nama_orangtua_ayah) }}" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="nama_orangtua_ibu" class="form-label">Nama Orang Tua Ibu</label>
                                                                <input type="text" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" id="nama_orangtua_ibu" name="nama_orangtua_ibu" value="{{ old('nama_orangtua_ibu', $anggotaKeluarga->nama_orangtua_ibu) }}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-1" style="font-size: 13px;">NIK: {{ $anggotaKeluarga->nik }}</p>
                                <p class="mb-1" style="font-size: 13px;">Jenis Kelamin: {{ $anggotaKeluarga->jenis_kelamin }}</p>
                                <p class="mb-1" style="font-size: 13px;">TTL: {{ $anggotaKeluarga->tempat_lahir }}, {{ $anggotaKeluarga->tanggal_lahir }}</p>
                                <p class="mb-1" style="font-size: 13px;">Agama: {{ $anggotaKeluarga->agama }}</p>
                                <p class="mb-1" style="font-size: 13px;">Pendidikan: {{ $anggotaKeluarga->tingkat_pendidikan }}</p>
                                <p class="mb-1" style="font-size: 13px;">Pekerjaan: {{ $anggotaKeluarga->jenis_pekerjaan }}</p>
                                <p class="mb-1" style="font-size: 13px;">Golongan Darah: {{ $anggotaKeluarga->golongan_darah }}</p>
                                <p class="mb-1" style="font-size: 13px;">Status Perkawinan: {{ $anggotaKeluarga->status_perkawinan }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="mt-2">
                        <p class="text-center">Tidak ada data</p>
                    </div>
                    @endforelse
                    @else
                    <div class="mt-2">
                        <p class="text-center">Tidak ada data</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@push('js-plugins')
<script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>

<!-- from cdn -->
<script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dialog.js"></script>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>


@endpush

@include('components.footer')
@endsection