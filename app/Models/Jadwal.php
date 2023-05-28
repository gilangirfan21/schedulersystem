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

    protected $table = "jadwal";
}
