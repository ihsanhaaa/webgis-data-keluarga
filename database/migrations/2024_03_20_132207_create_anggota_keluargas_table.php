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
            $table->foreignId('kartu_keluarga_id')->nullable();
            $table->integer('osm_id');
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('tingkat_pendidikan');
            $table->string('jenis_pekerjaan');
            $table->string('golongan_darah');
            $table->string('status_perkawinan');
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('status_hubungan_keluarga');
            $table->string('kewarganegaraan');
            $table->string('no_paspor')->nullable();
            $table->string('no_kitab')->nullable();
            $table->string('nama_orangtua_ayah');
            $table->string('nama_orangtua_ibu');
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
