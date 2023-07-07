<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Jam;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jad;

class BackupSchedulerController extends Controller
// class SchedulerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $id = 1;
        // $jadwalAwal = Jadwal::findOrFail($id);
        // // print_r;exit($jadwalAwal);
        
                    
        
        // $jadwalBaru = Jadwal::where('kode_jam', '!=', $jadwalAwal->kode_jam)
        //             ->where('kode_ruangan', '!=', $jadwalAwal->kode_ruangan)
        //             ->get();
        

        // dd($jadwalBaru);


        // PUKUL
        $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->where('jadwal.kode_matkul','!=','null')
                ->get();

                $i=0;
                for ($j=0; $j < count($jadwal); $j++) { 
                        $arrJadwal[$i]['kode_kelas'] = $jadwal[$j]['kode_kelas'];
                        $arrJadwal[$i]['kode_dosen'] = $jadwal[$j]['kode_dosen'];
                        $arrJadwal[$i]['dosen'] = $jadwal[$j]['dosen'];
                        $arrJadwal[$i]['kode_matkul'] = $jadwal[$j]['kode_matkul'];
                        $arrJadwal[$i]['pertemuan'] = $jadwal[$j]['pertemuan'];
                        $arrJadwal[$i]['kode_ruangan'] = $jadwal[$j]['kode_ruangan'];
                        $arrJadwal[$i]['hari'] = $jadwal[$j]['hari'];
                        $arrJadwal[$i]['tanggal'] = $jadwal[$j]['tanggal'];
                        $arrJadwal[$i]['kode_jam'] = [$jadwal[$j]['id'] => $jadwal[$j]['kode_jam']];
                        $tmp = $j;
                        $tmp++;
        
                        if ($tmp < count($jadwal)) {
                            if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas']) {
        
                                $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                $j++;
                                $tmp++;
        
                                // dd($arrJadwal[$i]['kode_kelas']);
                                // dd($jadwal[$tmp]['kode_kelas']);
                                if ($tmp < count($jadwal)) {
                                    if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas']) {                                
                                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                        $j++;
                                        $tmp++;
        
                                        if ($tmp < count($jadwal)) {
                                            if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas']) {                                
                                                $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                                $j++;
                                                $tmp++;
                            
                                                
                                            }
                                        }
                    
                                        
                                    }
                                }
                            }
                        }
                        // dd($arrJadwal);
                    $i++;
                }
        dd($arrJadwal);
        $jam = $jadwal[0]->kode_jam;
        // dd($jam);
        $arrJam = explode('/',$jam);
        $x = 1;
        $data = [];
        foreach($arrJam as $j) {

            // dd($j);
            $pukul = Jam::where('kode',$j)->first();
            // $pukul = $pukul[0];
            $data[$x]['jam'] = $pukul->jam;
            $data[$x]['jam_mulai'] = $pukul->jam;
            $data[$x]['jam_selesai'] = $pukul->jam;
            $x++;
        }

        // dd($data);


        // name = kode dosen
        $kode_dosen = $request->user()->name;

        // Data Dosen
        $dosen = User::leftJoin('ref_dosen', 'users.name', '=', 'ref_dosen.kode')
                ->where('name', '=', $kode_dosen)
                ->get();
        
        // IF search
        if($request->filled('search')){

            // IF admin or staff
            if (in_array($request->user()->role, [1,2])) {
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                        ->leftJoin('ref_kelas', 'jadwal.kode_kelas', '=', 'ref_kelas.kode')
                        ->where('jadwal.kode_dosen', '!=', null)
                        ->where('jadwal.kode_dosen', 'like', '%' . $request->search . '%')
                        ->where(function ($query) use ($request) {
                            $query->where('jadwal.kode_dosen', 'like', '%' . $request->search . '%')
                            ->orWhere('jadwal.kode_matkul', 'like', '%' . $request->search . '%')
                            ->orWhere('ref_matkul.matkul', 'like', '%' . $request->search . '%')
                            ->orWhere('jadwal.kode_kelas', 'like', '%' . $request->search . '%')
                            ->orWhere('jadwal.hari', 'like', '%' . $request->search . '%');
                        })
                        ->paginate(10);

            } else {
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                        ->leftJoin('ref_kelas', 'jadwal.kode_kelas', '=', 'ref_kelas.kode')
                        ->leftJoin('ref_hari', 'jadwal.kode_hari', '=', 'ref_hari.kode')
                        ->where('jadwal.kode_dosen', '!=', null)
                        ->where('ref_dosen.kode', '=',  $kode_dosen )
                        ->where(function ($query) use ($request) {
                            $query->where('jadwal.kode_matkul', 'like', '%' . $request->search . '%')
                            ->orWhere('ref_matkul.matkul', 'like', '%' . $request->search . '%')
                            ->orWhere('jadwal.kode_kelas', 'like', '%' . $request->search . '%')
                            ->orWhere('ref_hari.hari', 'like', '%' . $request->search . '%');
                        })
                        ->paginate(10);
            }

        }else{
            if (in_array($request->user()->role, [1,2])) {
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                        ->where('jadwal.kode_dosen', '!=', null)
                        ->paginate(10);
            } else {
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->where('ref_dosen.kode', '=', $kode_dosen)
                    ->where('jadwal.kode_dosen', '!=', null)
                    ->paginate(10);
            }
            
        }

        // CONVERT KODE JAM to JAM
        // foreach
        // dd($jadwal);
        
        return view('home', ['jadwal' => $jadwal, 'dosen' => $dosen]);
    }

    public function check(Request $request)
    {
        // dd($request);
        $jadwal = Jadwal::find($request->id);
        // dd($jadwal);
        return view('check',['jadwal' => $jadwal]);
    }

}
