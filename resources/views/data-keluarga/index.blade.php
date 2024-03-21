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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ $message }}.
            </div>
        @endif

        <a href="{{ route('data-keluarga.create') }}" class="btn btn-primary">Tambah Data Keluarga</a>
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


            // Fetch dan tambahkan layer GeoJSON pertama
            fetch("/geojson/Data1.geojson")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(geojsonData => {
                    // Fungsi untuk menangani klik pada fitur
                    function onEachFeature(feature, layer) {
                        layer.on('click', function (e) {
                            var osm_id = feature.properties.osm_id;

                            // Lakukan request ke server untuk mendapatkan data kartu_keluargas berdasarkan osm_id
                            fetch("/get-kartu-keluarga/" + osm_id)
                                .then(response => response.json())
                                .then(kartuKeluargaData => {
                                    // Buat popup dengan data kartu_keluargas
                                    var content = "Alamat: " + kartuKeluargaData.alamat; // Ganti dengan atribut yang Anda ingin tampilkan
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

                    const geojsonLayer1 = L.geoJson(geojsonData, {
                        onEachFeature: onEachFeature // Panggil fungsi onEachFeature
                    }).addTo(map);
                })
                .catch(error => {
                    console.error("Error fetching or processing GeoJSON data:", error);
                });


        </script>
    @endpush
@endsection
