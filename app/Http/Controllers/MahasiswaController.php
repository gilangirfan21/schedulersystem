<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        if($request->filled('search')){
            $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_kelas', 'jadwal.kode_kelas', '=', 'ref_kelas.kode')
                    ->where('jadwal.kode_dosen', 'like', '%' . $request->search . '%')
                    ->orWhere('ref_dosen.dosen', 'like', '%' . $request->search . '%')
                    ->orWhere('jadwal.kode_matkul', 'like', '%' . $request->search . '%')
                    ->orWhere('ref_matkul.matkul', 'like', '%' . $request->search . '%')
                    ->orWhere('jadwal.kode_kelas', 'like', '%' . $request->search . '%')
                    ->paginate(10);
        }else{
            $jadwal = Jadwal::paginate(10);
        }
        return view('mahasiswa', ['jadwal' => $jadwal]);
    }
}
