<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth')->only();
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // name = kode dosen
        $kode_dosen = $request->user()->name;
        
        if($request->filled('search')){
            // $jadwal = DB:table()
            // dd('s');
            // dd($request->search);
            // $jadwal = Jadwal::where('kode_dosen', 'like', '%' . $request->search . '%' )
            //     ->orWhere('kode_kelas', 'like', '%' . $request->search . '%' )
            //     ->paginate(10);

            $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    // ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    // ->leftJoin('ref_kelas', 'jadwal.kode_kelas', '=', 'ref_kelas.kode')
                    ->where('ref_dosen.kode', '=',  $kode_dosen )
                    // ->where('jadwal.kode_dosen', 'like', '%' . $request->search . '%')
                    // ->orWhere('ref_dosen.dosen', 'like', '%' . $request->search . '%')
                    // ->where('jadwal.kode_matkul', 'like', '%' . $request->search . '%')
                    // ->orWhere('ref_matkul.matkul', 'like', '%' . $request->search . '%')
                    // ->orWhere('jadwal.kode_kelas', 'like', '%' . $request->search . '%')
                    ->paginate(10);
    
            
            // dd($jadwal);

        }else{
            $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
            ->where('ref_dosen.kode', '=', $kode_dosen)
            ->paginate(10);
        }
        
        return view('home', ['jadwal' => $jadwal]);
    }
}
