<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    public function jadwal() : HasMany
    {
        return $this->HasMany(Jadwal::class);
    }

    public function tb_jurusan() : BelongsTo
    {
        return $this->BelongsTo(Jurusan::class, 'kode_jurusan', 'kode');
    }

    protected $table = 'ref_kelas';
}
