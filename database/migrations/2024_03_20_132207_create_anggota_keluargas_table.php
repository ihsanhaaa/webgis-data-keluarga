<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggota_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('kecamatan_id');
            $table->foreignId('desa_id');
            $table->foreignId('provinsi_id');
            $table->string('nama');
            $table->string('nik');
            $table->string('jenis_kelamin');
            $table->string('alamat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('jenis_pekerjaan');
            $table->string('golongan_darah');
            $table->string('status_perkawinan');
            $table->date('tanggal_perkawinan');
            $table->string('status_hubungan_keluarga');
            $table->string('kewarganegaraan');
            $table->string('no_paspor');
            $table->string('no_kitab');
            $table->string('ayah');
            $table->string('ibu');
            $table->date('data_ditambahkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_keluargas');
    }
};
