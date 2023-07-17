<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TanggalMerah extends Model
{
    use HasFactory;
    
    public function jadwal() : HasMany
    {
        return $this->HasMany(Jadwal::class);
    }

    protected $table = 'ref_tanggal_merah';

    protected $fillable = ['tanggal_merah', 'ket'];
}
