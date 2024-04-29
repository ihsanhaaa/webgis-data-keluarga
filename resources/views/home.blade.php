@extends('layouts.app')

@section('content')
@push('css-plugins')
<link rel="stylesheet" href="{{ asset('style.css') }}" />

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    #map {
        height: 500px;
    }
</style>
@endpush

@include('components.navbar')

<!-- Main -->
<main>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ $message }}.
    </div>
    @endif

    @if(Auth::user()->is_admin)
        <div class="my-5">
            <a href="{{ route('laporan-kartu-keluarga.export') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Laporan</a>
        </div>
    @endif

    <!-- Hero-Section -->
    <h1 class="text-[25px] font-bold mb-3">
        <p class="text-left">Sebaran Data Keluarga Di Kabupaten Sambas</p>
    </h1>
    <div id="map"></div>

    <!-- Tabel/Grafik -->
    <div class="flex mx-[105px]">
        <div class="basis-1/2">
            <div class="m-10 p-10 border border-slate-300 rounded-[10px]">
                <h4 class="text-[16px] md:text-[20px] text-[#5eb24f] font-medium mb-8">
                    Jumlah Desa di Kecamatan Sambas
                </h4>
                <div style="width: 350px;">
                    <canvas id="chartDesa" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="basis-1/2">
            <div class="m-10 p-10 border border-slate-300 rounded-[10px]">
                <h4 class="text-[16px] md:text-[20px] text-[#5eb24f] font-medium mb-8">
                    Jumlah Keluarga di Kecamatan Sambas
                </h4>
                <div style="width: 350px;">
                    <canvas id="chartKecamatan" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

@push('js-plugins')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartKecamatan').getContext('2d');

    var labels = @json($labelsKecamatan);
    var jumlah = @json($jumlahKecamatan);

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Keluarga',
                data: jumlah,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('chartDesa').getContext('2d');

    var labels = @json($labelsDesa);
    var jumlah = @json($jumlahDesa);

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Desa',
                data: jumlah,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
                layer.on('click', function(e) {
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
                                layer.setStyle({
                                    fillColor: 'green'
                                });
                            } else {
                                content += "Belum ada data";
                                // Ubah warna poligon menjadi abu-abu jika data kartu_keluarga tidak tersedia
                                layer.setStyle({
                                    fillColor: 'gray'
                                });
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
                            content += "<tr><td colspan='2' class='text-center'> <br>" +
                                "<a href='/tambah-data/" + osm_id + "' class='bg-orange-400 hover:bg-orange-600 text-white py-2 px-4 my-3 rounded'>Tambah Data</a>" +
                                "<a href='/lihat-data/" + osm_id + "' class='bg-green-400 hover:bg-green-600 text-white py-2 px-4 my-3 rounded'>Lihat Detail</a>" +
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


        fetch("/geojson/ade-irfan.geojson")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(geojsonData => {
            function onEachFeature(feature, layer) {
                layer.on('click', function(e) {
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
                                layer.setStyle({
                                    fillColor: 'green'
                                });
                            } else {
                                content += "Belum ada data";
                                // Ubah warna poligon menjadi abu-abu jika data kartu_keluarga tidak tersedia
                                layer.setStyle({
                                    fillColor: 'gray'
                                });
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

                            content += "</td></tr> ";

                            // Tambahkan baris untuk tombol "Tambah Data" dan "Lihat Detail"
                            content += "<tr><td colspan='2' class='text-center'> <br>" +
                                "<a href='/tambah-data/" + osm_id + "' class='bg-orange-400 hover:bg-orange-600 text-white py-2 px-4 my-3 rounded'>Tambah Data</a>" +
                                "<a href='/lihat-data/" + osm_id + "' class='bg-green-400 hover:bg-green-600 text-white py-2 px-4 my-3 rounded'>Lihat Detail</a>" +
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


        fetch("/geojson/maulana.geojson")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(geojsonData => {
            function onEachFeature(feature, layer) {
                layer.on('click', function(e) {
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
                                layer.setStyle({
                                    fillColor: 'green'
                                });
                            } else {
                                content += "Belum ada data";
                                // Ubah warna poligon menjadi abu-abu jika data kartu_keluarga tidak tersedia
                                layer.setStyle({
                                    fillColor: 'gray'
                                });
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
                            content += "<tr><td colspan='2' class='text-center'> <br>" +
                                "<a href='/tambah-data/" + osm_id + "' class='bg-orange-400 hover:bg-orange-600 text-white py-2 px-4 my-3 rounded'>Tambah Data</a>" +
                                "<a href='/lihat-data/" + osm_id + "' class='bg-green-400 hover:bg-green-600 text-white py-2 px-4 my-3 rounded'>Lihat Detail</a>" +
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

@include('components.footer')
@endsection