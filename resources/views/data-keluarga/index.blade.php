@extends('layouts.app')

@section('title')
    Data Keluarga
@endsection

@section('content')
    @push('css-plugins')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <style>
            #map {
                height: 500px;
            }
        </style>
    @endpush

    @include('components.navbar-admin')

    <div class="container my-3">
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
    </div>
    <div class="card container">
        <div class="card-body">
            <div id="map"></div>
        </div>
    </div>

    @push('javascript-plugins')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            var map = L.map('map').setView([1.3624869559381243, 109.30223553446231], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            fetch("/geojson/jorgi.geojson")
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(geojsonData => {
        function onEachFeature(feature, layer) {
            layer.on('click', function (e) {
                var osm_id = feature.properties.osm_id;

                // Lakukan request ke server untuk mendapatkan data kartu_keluargas berdasarkan osm_id
                fetch("/get-kartu-keluarga/" + osm_id)
                    .then(response => response.json())
                    .then(kartuKeluargaData => {
                        // Buat isi popup dengan data kartu_keluargas dalam format tabel
                        var content = "<table class='table'>";

                        // Tambahkan baris untuk anggota keluarga
                        content += "<tr><td><b>Nama KK:</b></td><td>";

                        // Tampilkan nama kepala keluarga jika ada, jika tidak, tampilkan pesan
                        if (kartuKeluargaData.anggota_keluargas && kartuKeluargaData.anggota_keluargas.length > 0) {
                            var kepalaKeluarga = kartuKeluargaData.anggota_keluargas[0];
                            content += kepalaKeluarga.nama_lengkap;
                            // Ubah warna poligon menjadi hijau jika data kartu_keluarga tersedia
                            layer.setStyle({ fillColor: 'green' });
                        } else {
                            content += "Belum ada data";
                            // Ubah warna poligon menjadi abu-abu jika data kartu_keluarga tidak tersedia
                            layer.setStyle({ fillColor: 'gray' });
                        }

                        content += "</td></tr>";

                        // Tambahkan baris untuk alamat
                        content += "<tr><td><b>Alamat:</b></td><td>";

                        // Tampilkan alamat jika tersedia, jika tidak, tampilkan pesan
                        if (kartuKeluargaData.alamat) {
                            content += kartuKeluargaData.alamat;
                        } else {
                            content += "Belum ada data";
                        }

                        content += "</td></tr>";

                        // Tambahkan baris untuk tombol "Tambah Data" dan "Lihat Detail"
                        content += "<tr><td colspan='2' class='text-center'>" +
                                        "<a href='/tambah-data/" + osm_id + "' class='btn btn-primary btn-sm text-white mx-1'>Tambah Data</a>" +
                                        "<a href='/lihat-data/" + osm_id + "' class='btn btn-success btn-sm text-white mx-1'>Lihat Detail</a>" +
                                    "</td></tr>";

                        content += "</table>";

                        // Buat popup dengan isi yang telah disiapkan
                        L.popup()
                            .setLatLng(e.latlng)
                            .setContent(content)
                            .openOn(map);
                    })
                    .catch(error => {
                        console.error("Error fetching kartu_keluargas data:", error);
                    });
            });
        }

        // Buat layer GeoJSON dan atur fungsi onEachFeature sebagai event handler
        const geojsonLayer = L.geoJson(geojsonData, {
            onEachFeature: onEachFeature
        }).addTo(map);
    })
    .catch(error => {
        console.error("Error fetching or processing GeoJSON data:", error);
    });


        </script>
    @endpush
@endsection
