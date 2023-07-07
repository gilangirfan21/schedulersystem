<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\TanggalMerah;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // check kode_dosen
        $kode_dosen = (isset($request->kode_dosen) && $request->kode_dosen != '-') ? $request->kode_dosen : null;
        $symbolCheck = (isset($request->kode_dosen) && $request->kode_dosen != '-') ? '=' : '!=';

        $listTanggalMerah = [];
        $queryTanggalMerah = TanggalMerah::select('tanggal_merah')
                        ->get();
        foreach ($queryTanggalMerah as $tanggal) {
            array_push($listTanggalMerah, $tanggal['tanggal_merah']);
        }
        
        //selet all data
        try {
            $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->where('jadwal.kode_dosen', $symbolCheck, $kode_dosen)
                ->get();

            $arrJadwal = [];
            $length = count($jadwal);
            $i=0;
            for ($j = 0; $j < $length; $j++) {
                $arrJadwal[$i]['kode_kelas'] = $jadwal[$j]['kode_kelas'];
                $arrJadwal[$i]['kode_dosen'] = $jadwal[$j]['kode_dosen'];
                $arrJadwal[$i]['dosen'] = $jadwal[$j]['dosen'];
                $arrJadwal[$i]['kode_matkul'] = $jadwal[$j]['kode_matkul'];
                $arrJadwal[$i]['matkul'] = $jadwal[$j]['matkul'];
                $arrJadwal[$i]['pertemuan'] = $jadwal[$j]['pertemuan'];
                $arrJadwal[$i]['kode_ruangan'] = $jadwal[$j]['kode_ruangan'];
                $arrJadwal[$i]['hari'] = $jadwal[$j]['hari'];
                $arrJadwal[$i]['tanggal'] = $jadwal[$j]['tanggal'];
                $arrJadwal[$i]['flag'] = null;
                $arrJadwal[$i]['concat_kode_jam'] = $jadwal[$j]['id'];
                $arrJadwal[$i]['concat_jam'] = $jadwal[$j]['kode_jam'];
                $arrJadwal[$i]['kode_jam'] = [$jadwal[$j]['id'] => $jadwal[$j]['kode_jam']];
                $arrJadwal[$i]['ket_jadwal'] = $jadwal[$j]['ket_jadwal'];

                // flagging tidak boleh ada kegiatan perkuliahan (tanggal merah, uas, uts, ...)
                if (in_array($arrJadwal[$i]['tanggal'], $listTanggalMerah)) {
                    $arrJadwal[$i]['flag'] = 'L';
                }

                // $tmp = $j;
                // $tmp++;
                $tmp = $j + 1; // Start the inner loop from the next index
                while ($tmp < $length && $arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['kode_ruangan'] == $jadwal[$tmp]['kode_ruangan'] && $arrJadwal[$i]['kode_dosen'] == $jadwal[$tmp]['kode_dosen']  && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal'] && $arrJadwal[$i]['pertemuan'] == $jadwal[$tmp]['pertemuan']) {
                    $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwal[$tmp]['id'];
                    $arrJadwal[$i]['concat_jam'] .= '/' . $jadwal[$tmp]['kode_jam'];
                    $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];

                    // $j++;
                    $tmp++;
                }
                $j = $tmp - 1;
                $i++;
            }

            return response()->json([
                'status' => '200',
                'jadwal' => $arrJadwal
            ]);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $listAwalArr = explode('/', $request->list_id_awal);
        $listBaruArr = explode('/', $request->list_id_baru);
        // "kode_dosen" => "DSN327"
        // "list_id_old" => "3/4/5"
        // "list_id_new" => "15/16/17"
        $type = $request->type;

        if (strtoupper($type) == 'SEMENTARA') {
            
            try {
                for ($i=0; $i < count($listAwalArr); $i++) { 
                    $dataAwal = Jadwal::findOrFail($listAwalArr[$i]);
                    $dataBaru = Jadwal::findOrFail($listBaruArr[$i]);
                        // Copy to new schadule
                        $dataBaru->kode_kelas = $dataAwal->kode_kelas;
                        $dataBaru->kode_matkul = $dataAwal->kode_matkul;
                        $dataBaru->pertemuan = $dataAwal->pertemuan;
                        $dataBaru->kode_dosen = $dataAwal->kode_dosen;
                        $dataBaru->ket_jadwal = $dataAwal->tanggal . ';' . $request->list_id_awal . ';' . $dataAwal->kode_ruangan;
                        $dataBaru->save();
            
                        // Remove old schadule
                        $dataAwal->kode_kelas = null;
                        $dataAwal->kode_matkul = null;
                        $dataAwal->pertemuan = null;
                        $dataAwal->kode_dosen = null;
                        $dataAwal->ket_jadwal = null;
                        $dataAwal->save();
            
                
                }
            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
            }
    
            return response()->json([
                'status' => '200',
                'message' => 'Update berhasil'
            ]);
        } elseif (strtoupper($type) == 'PERMANEN') {
            # code...
        } else {
            $error = [
                'error' => 'Type is required!'
            ];
            return response()->json($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
