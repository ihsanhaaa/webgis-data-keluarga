<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsis';

    protected $guarded = ['id'];

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class);
    }

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function desas()
    {
        return $this->hasMany(Desa::class);
    }
}
