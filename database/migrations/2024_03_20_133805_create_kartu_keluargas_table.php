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
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('osm_id');
            $table->foreignId('user_id');
            $table->foreignId('kecamatan_id');
            $table->foreignId('desa_id');
            $table->foreignId('provinsi_id');
            $table->foreignId('kabupaten_id');
            $table->string('no_kk');
            $table->string('alamat');
            $table->string('rtrw');
            $table->string('kode_pos');
            $table->string('foto_rumah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluargas');
    }
};
