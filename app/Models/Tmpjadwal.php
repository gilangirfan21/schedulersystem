<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmpjadwal extends Model
{
    use HasFactory;

    protected $table = 'tmp_jadwal';

    protected $fillable = ['id', 'kode_kelas', 'hari', 'tanggal', 'kode_matkul', 'pertemuan', 'kode_ruangan', 'kode_jam', 'kode_dosen', 'ket_tmp'];
}
