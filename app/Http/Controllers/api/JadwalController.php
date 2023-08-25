<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\TanggalMerah;
use App\Models\HapusHistoryJadwal;
use App\Models\RiwayatPerubahanJadwal;
use Illuminate\Support\Facades\Auth;

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
        
        try {
            
            if (isset($request->list_id)) {
                // jadwal awal
                $listIdAwal = $request->list_id;
                $listIdAwal = explode('/', $listIdAwal);
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
                ->whereBetween('jadwal.id', [reset($listIdAwal), end($listIdAwal)])
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
                    $arrJadwal[$i]['ket_tanggal_merah'] = $jadwal[$j]['ket'];
                    $tmp = $j + 1; // Start the inner loop from the next index
                    while ($tmp < $length && $arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['kode_ruangan'] == $jadwal[$tmp]['kode_ruangan'] && $arrJadwal[$i]['kode_dosen'] == $jadwal[$tmp]['kode_dosen']  && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal'] && $arrJadwal[$i]['pertemuan'] == $jadwal[$tmp]['pertemuan']) {
                        $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwal[$tmp]['id'];
                        $arrJadwal[$i]['concat_jam'] .= '/' . $jadwal[$tmp]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                        $tmp++;
                    }
                    $j = $tmp - 1;
                    $i++;
                }
                
            } else {
                //selet all data
                $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
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
                    $arrJadwal[$i]['ket_tanggal_merah'] = $jadwal[$j]['ket'];
                    // flagging tidak boleh ada kegiatan perkuliahan (tanggal merah, uas, uts, ...)
                    if (in_array($arrJadwal[$i]['tanggal'], $listTanggalMerah)) {
                        $arrJadwal[$i]['flag'] = 'L';
                    }
                    $tmp = $j + 1; // Start the inner loop from the next index
                    while ($tmp < $length && $arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['kode_ruangan'] == $jadwal[$tmp]['kode_ruangan'] && $arrJadwal[$i]['kode_dosen'] == $jadwal[$tmp]['kode_dosen']  && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal'] && $arrJadwal[$i]['pertemuan'] == $jadwal[$tmp]['pertemuan']) {
                        $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwal[$tmp]['id'];
                        $arrJadwal[$i]['concat_jam'] .= '/' . $jadwal[$tmp]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                        $tmp++;
                    }
                    $j = $tmp - 1;
                    $i++;
                }
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

    // Show jadwal yang bentrok dengan tanggal merah 
    public function jadwaltanggalmerah(Request $request) {
        // check kode_dosen
        $kode_dosen = $request->kode_dosen;

        $listTanggalMerah = [];
        $queryTanggalMerah = TanggalMerah::select('tanggal_merah')
                        ->get();
        foreach ($queryTanggalMerah as $tanggal) {
            array_push($listTanggalMerah, $tanggal['tanggal_merah']);
        }

        try {
                if (strlen($kode_dosen) > 2) {
                    $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                        ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
                        ->where('jadwal.kode_dosen', '=', $kode_dosen)
                        ->where('ref_tanggal_merah.ket', '!=', null)
                        ->get();
                } else {
                    $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
                    ->where('ref_tanggal_merah.ket', '!=', null)
                    ->where('jadwal.kode_dosen', '!=', null)
                    ->get();
                }
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
                    $arrJadwal[$i]['ket_tanggal_merah'] = $jadwal[$j]['ket'];
                    // flagging tidak boleh ada kegiatan perkuliahan (tanggal merah, uas, uts, ...)
                    if (in_array($arrJadwal[$i]['tanggal'], $listTanggalMerah)) {
                        $arrJadwal[$i]['flag'] = 'L';
                    }
                    $tmp = $j + 1; // Start the inner loop from the next index
                    while ($tmp < $length && $arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['kode_ruangan'] == $jadwal[$tmp]['kode_ruangan'] && $arrJadwal[$i]['kode_dosen'] == $jadwal[$tmp]['kode_dosen']  && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal'] && $arrJadwal[$i]['pertemuan'] == $jadwal[$tmp]['pertemuan']) {
                        $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwal[$tmp]['id'];
                        $arrJadwal[$i]['concat_jam'] .= '/' . $jadwal[$tmp]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
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

    // Show jadwal yang bentrok dengan tanggal merah 
    public function jadwaltanggalmerahpopup(Request $request) {
        // check kode_dosen
        $kode_dosen = $request->kode_dosen;

        $listTanggalMerah = [];
        $queryTanggalMerah = TanggalMerah::select('tanggal_merah')
                        ->get();
        foreach ($queryTanggalMerah as $tanggal) {
            array_push($listTanggalMerah, $tanggal['tanggal_merah']);
        }

        try {
                if (strlen($kode_dosen) > 2) {
                    $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                        ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
                        ->where('jadwal.kode_dosen', '=', $kode_dosen)
                        ->where('ref_tanggal_merah.ket', '!=', null)
                        ->get();
                } else {
                    $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_tanggal_merah', 'jadwal.tanggal', '=', 'ref_tanggal_merah.tanggal_merah')
                    ->where('ref_tanggal_merah.ket', '!=', null)
                    ->get();
                }
                $arrJadwal = [];
                $length = count($jadwal);
                $i=0;
                for ($j = 0; $j < $length; $j++) {
                    $arrJadwal[$i]['tanggal'] = $jadwal[$j]['tanggal'];
                    $arrJadwal[$i]['ket_tanggal_merah'] = $jadwal[$j]['ket'];
                    $i++;
                }
                $arrJadwal = collect($arrJadwal)->unique()->values()->all();
                $i=0;
                $listTglMerah = '';
                for ($j = 0; $j < count($arrJadwal); $j++) {
                    $listTglMerah .= ', ' . $arrJadwal[$j]['tanggal'] . ' (' . $arrJadwal[$j]['ket_tanggal_merah'] .')';
                    $i++;
                }
                
                $data = [
                    'tanggalMerah' => substr($listTglMerah, 2)
                ];
            return response()->json([
                'status' => '200',
                'jadwal' => $data
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
        if (!isset($request->user_id)) {
            return response()->json([
                'error' => 'user_id is required!'
            ]);
        }

        $listKodeJamAwal = [];
        for ($i=0; $i < count($listAwalArr); $i++) { 
            $jamAwal = Jadwal::select('kode_jam')
                    ->where('id',$listAwalArr[$i])
                    ->get();
            array_push($listKodeJamAwal, $jamAwal[0]['kode_jam']);
        }
        $listKodeJamAwal = implode('/', $listKodeJamAwal);

        if (strtoupper($type) == 'SEMENTARA') {
            try {
                for ($i=0; $i < count($listAwalArr); $i++) { 
                    $dataAwal = Jadwal::findOrFail($listAwalArr[$i]);
                    $dataBaru = Jadwal::findOrFail($listBaruArr[$i]);
                    $history = new RiwayatPerubahanJadwal;
                    // Insert to history
                    $history->id_akun = $request->user_id;
                    $history->kode_kelas = $dataAwal->kode_kelas;
                    $history->hari = $dataAwal->hari;
                    $history->tanggal = $dataAwal->tanggal;
                    $history->kode_matkul = $dataAwal->kode_matkul;
                    $history->pertemuan = $dataAwal->pertemuan;
                    $history->kode_ruangan = $dataAwal->kode_ruangan;
                    $history->kode_jam = $dataAwal->kode_jam;
                    $history->kode_dosen = $dataAwal->kode_dosen;
                    $history->hari_new = $dataBaru->hari;
                    $history->tanggal_new = $dataBaru->tanggal;
                    $history->kode_ruangan_new = $dataBaru->kode_ruangan;
                    $history->kode_jam_new = $dataBaru->kode_jam;
                    $history->save();
                    // Copy to new schadule
                    $dataBaru->kode_kelas = $dataAwal->kode_kelas;
                    $dataBaru->kode_matkul = $dataAwal->kode_matkul;
                    $dataBaru->pertemuan = $dataAwal->pertemuan;
                    $dataBaru->kode_dosen = $dataAwal->kode_dosen;
                    $dataBaru->ket_jadwal = $request->list_id_awal . ';' . $listKodeJamAwal . ';' . $dataAwal->tanggal . ';' . $dataAwal->kode_ruangan;
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

    public function riwayat(Request $request) {
        // check kode_dosen
        $kode_dosen = $request->kode_dosen;
        
        try {
            // riwayat perubahan jadwal
            if (strlen($kode_dosen) > 2) {
                $riwayatJadwal = RiwayatPerubahanJadwal::leftJoin('ref_dosen', 'history_perubahan_jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('users', 'history_perubahan_jadwal.id_akun', '=', 'users.name')
                ->leftJoin('ref_matkul', 'history_perubahan_jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->where('history_perubahan_jadwal.kode_dosen', '=', $kode_dosen)
                ->select('history_perubahan_jadwal.*','users.nama','ref_dosen.dosen','ref_matkul.matkul')
                ->get();
            } else {
                $riwayatJadwal = RiwayatPerubahanJadwal::leftJoin('ref_dosen', 'history_perubahan_jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('users', 'history_perubahan_jadwal.id_akun', '=', 'users.name')
                ->leftJoin('ref_matkul', 'history_perubahan_jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->select('history_perubahan_jadwal.*','users.nama','ref_dosen.dosen','ref_matkul.matkul')
                ->get();
            }
            $arrRiwayatJadwal = [];
            $length = count($riwayatJadwal);
            $i=0;
            for ($j = 0; $j < $length; $j++) {
                $arrRiwayatJadwal[$i]['id_akun'] = $riwayatJadwal[$j]['id_akun'];
                $arrRiwayatJadwal[$i]['nama'] = $riwayatJadwal[$j]['nama'];
                $arrRiwayatJadwal[$i]['kode_kelas'] = $riwayatJadwal[$j]['kode_kelas'];
                $arrRiwayatJadwal[$i]['kode_dosen'] = $riwayatJadwal[$j]['kode_dosen'];
                $arrRiwayatJadwal[$i]['dosen'] = $riwayatJadwal[$j]['dosen'];
                $arrRiwayatJadwal[$i]['kode_matkul'] = $riwayatJadwal[$j]['kode_matkul'];
                $arrRiwayatJadwal[$i]['matkul'] = $riwayatJadwal[$j]['matkul'];
                $arrRiwayatJadwal[$i]['pertemuan'] = $riwayatJadwal[$j]['pertemuan'];
                $arrRiwayatJadwal[$i]['kode_ruangan'] = $riwayatJadwal[$j]['kode_ruangan'];
                $arrRiwayatJadwal[$i]['kode_ruangan_new'] = $riwayatJadwal[$j]['kode_ruangan_new'];
                $arrRiwayatJadwal[$i]['hari'] = $riwayatJadwal[$j]['hari'];
                $arrRiwayatJadwal[$i]['hari_new'] = $riwayatJadwal[$j]['hari_new'];
                $arrRiwayatJadwal[$i]['tanggal'] = $riwayatJadwal[$j]['tanggal'];
                $arrRiwayatJadwal[$i]['tanggal_new'] = $riwayatJadwal[$j]['tanggal_new'];
                $arrRiwayatJadwal[$i]['concat_kode_jam'] = $riwayatJadwal[$j]['id_history'];
                $arrRiwayatJadwal[$i]['concat_jam'] = $riwayatJadwal[$j]['kode_jam'];
                $arrRiwayatJadwal[$i]['concat_jam_new'] = $riwayatJadwal[$j]['kode_jam_new'];
                $arrRiwayatJadwal[$i]['kode_jam'] = [$riwayatJadwal[$j]['id_history'] => $riwayatJadwal[$j]['kode_jam']];
                $arrRiwayatJadwal[$i]['ket_jadwal'] = $riwayatJadwal[$j]['ket'];
                $arrRiwayatJadwal[$i]['updated_at'] = $riwayatJadwal[$j]['updated_at'];
                $arrRiwayatJadwal[$i]['created_at'] = $riwayatJadwal[$j]['created_at'];
                $tmp = $j + 1; // Start the inner loop from the next index
                while ($tmp < $length && $arrRiwayatJadwal[$i]['kode_kelas'] == $riwayatJadwal[$tmp]['kode_kelas'] && $arrRiwayatJadwal[$i]['kode_ruangan'] == $riwayatJadwal[$tmp]['kode_ruangan'] && $arrRiwayatJadwal[$i]['kode_dosen'] == $riwayatJadwal[$tmp]['kode_dosen']  && $arrRiwayatJadwal[$i]['tanggal'] == $riwayatJadwal[$tmp]['tanggal'] && $arrRiwayatJadwal[$i]['pertemuan'] == $riwayatJadwal[$tmp]['pertemuan'] && $arrRiwayatJadwal[$i]['updated_at'] == $riwayatJadwal[$tmp]['updated_at']) {
                    $arrRiwayatJadwal[$i]['concat_kode_jam'] .= '-' . $riwayatJadwal[$tmp]['id_history'];
                    $arrRiwayatJadwal[$i]['concat_jam'] .= '/' . $riwayatJadwal[$tmp]['kode_jam'];
                    $arrRiwayatJadwal[$i]['concat_jam_new'] .= '/' . $riwayatJadwal[$tmp]['kode_jam_new'];
                    $arrRiwayatJadwal[$i]['kode_jam'][$riwayatJadwal[$tmp]['id_history']] = $riwayatJadwal[$tmp]['kode_jam'];
                    $tmp++;
                }
                $j = $tmp - 1;
                $i++;
            }
            return response()->json([
                'status' => '200',
                'jadwal' => $arrRiwayatJadwal
            ]);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error);
        }
    }
}
