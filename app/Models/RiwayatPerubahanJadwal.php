<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RiwayatPerubahanJadwal extends Model
{
    use HasFactory;

    public function tb_users() : BelongsTo
    {
        return $this->BelongsTo(Role::class, 'id_akun', 'name');
    }

    public function tb_dosen() : BelongsTo
    {
        return $this->BelongsTo(Dosen::class, 'kode_dosen', 'kode');
    }

    public function tb_matkul() : BelongsTo
    {
        return $this->BelongsTo(Matkul::class, 'kode_matkul', 'kode');
    }

    protected $table = 'history_perubahan_jadwal';

    protected $guarded = []; // is fillable all
}
