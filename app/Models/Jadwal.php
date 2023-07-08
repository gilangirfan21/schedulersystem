<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    public function tb_dosen() : BelongsTo
    {
        return $this->BelongsTo(Dosen::class, 'kode_dosen', 'kode');
    }

    public function tb_matkul() : BelongsTo
    {
        return $this->BelongsTo(Matkul::class, 'kode_matkul', 'kode');
    }

    public function tb_hari() : BelongsTo
    {
        return $this->BelongsTo(Hari::class, 'kode_hari', 'kode');
    }

    public function tb_jam() : BelongsTo
    {
        return $this->BelongsTo(Hari::class, 'kode_jam', 'kode');
    }

    public function tb_ruangan() : BelongsTo
    {
        return $this->BelongsTo(Ruangan::class, 'kode_ruangan', 'kode');
    }

    protected $table = "jadwal";

    protected $fillable = ['kode_kelas', 'hari', 'tanggal', 'kode_matkul', 'pertemuan', 'kode_ruangan', 'kode_jam', 'kode_dosen'];

}
