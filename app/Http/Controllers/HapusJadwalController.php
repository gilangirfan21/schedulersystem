<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\HapusHistoryJadwal;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPerubahanJadwal;

class HapusJadwalController extends Controller
{
    public function hapus(Request $request) {
        $role = Auth::user()->role;
        $user_id = Auth::user()->name;
        if (isset($role) && in_array($role,[1,2])) {
            $datetime = date('Y-m-d H:i:s');
            $countData = Jadwal::count();
            if ($countData) {
                HapusHistoryJadwal::create([
                    'id_akun' => $user_id,
                    'jumlah_data' => $countData,
                    'time' => $datetime
                ]);
                // TRUNCATE TABLE HISTORY
                RiwayatPerubahanJadwal::truncate();
                // TRUCATE TABLE JAWDAL
                Jadwal::truncate();
                
                return redirect()->back()->with('success', 'Semua Jadwal Berhasil Dihapus');;
            } 
        }
    }
}
