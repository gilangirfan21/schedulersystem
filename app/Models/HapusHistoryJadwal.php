<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HapusHistoryJadwal extends Model
{
    use HasFactory;

    protected $table = 'history_hapus_jadwal';

    protected $fillable = ['id', 'id_akun', 'jumlah_data', 'time'];
}
