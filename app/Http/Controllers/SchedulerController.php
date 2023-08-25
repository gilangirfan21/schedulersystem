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
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class SchedulerController extends Controller
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
        return view('home');
    }

    public function show(Request $request)
    {
        // name = kode dosen
        $kode_dosen = $request->user()->name;

        // Data Dosen
        $dosen = User::leftJoin('ref_dosen', 'users.name', '=', 'ref_dosen.kode')
                ->where('name', '=', $kode_dosen)
                ->get();
        
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
            $i++;
        }
        $jadwal = $arrJadwal;
        return view('home', ['jadwal' => $jadwal, 'dosen' => $dosen]);
    }

    public function check(Request $request)
    {
        $countArr = explode('/', $request->listId);
        $count_time = count($countArr);
        $perubahanData = [
            'type' => $request->type,
            'listId' => $request->listId,
            'count_time' => $count_time
        ];
        return view('check',['perubahanData' => $perubahanData]);
    }

    public function riwayat(Request $request)
    {
        return view('riwayatperubahanjadwal');
    }

    public function jadwaltanggalmerah(Request $request)
    {
        return view('jadwaltanggalmerah');
    }


}
