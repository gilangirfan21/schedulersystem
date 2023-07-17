<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matkul extends Model
{
    use HasFactory;

    public function jadwal() : HasMany
    {
        return $this->HasMany(Jadwal::class);
    }

    public function riwayatperubahanjadwal() : HasMany
    {
        return $this->HasMany(RiwayatPerubahanJadwal::class);
    }

    protected $table = 'ref_matkul';
}
