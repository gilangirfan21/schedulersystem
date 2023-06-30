<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
        
        //selet all data
        try {
            $jadwal = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->where('jadwal.kode_dosen', $symbolCheck, $kode_dosen)
                    ->get();

            $i=0;
            for ($j=0; $j < count($jadwal); $j++) { 
                $arrJadwal[$i]['kode_kelas'] = $jadwal[$j]['kode_kelas'];
                $arrJadwal[$i]['kode_dosen'] = $jadwal[$j]['kode_dosen'];
                $arrJadwal[$i]['dosen'] = $jadwal[$j]['dosen'];
                $arrJadwal[$i]['kode_matkul'] = $jadwal[$j]['kode_matkul'];
                $arrJadwal[$i]['matkul'] = $jadwal[$j]['matkul'];
                $arrJadwal[$i]['pertemuan'] = $jadwal[$j]['pertemuan'];
                $arrJadwal[$i]['kode_ruangan'] = $jadwal[$j]['kode_ruangan'];
                $arrJadwal[$i]['hari'] = $jadwal[$j]['hari'];
                $arrJadwal[$i]['tanggal'] = $jadwal[$j]['tanggal'];
                $arrJadwal[$i]['concat_kode_jam'] = $jadwal[$j]['id'];
                $arrJadwal[$i]['concat_jam'] = $jadwal[$j]['kode_jam'];
                $arrJadwal[$i]['kode_jam'] = [$jadwal[$j]['id'] => $jadwal[$j]['kode_jam']];
                $arrJadwal[$i]['ket_jadwal'] = $jadwal[$j]['ket_jadwal'];
                $tmp = $j;
                $tmp++;
                // concat 2
                if ($tmp < count($jadwal)) {
                    if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                        $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                        $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                        $j++;
                        $tmp++;
                        // dd($arrJadwal[$i]['kode_kelas']);
                        // dd($jadwal[$tmp]['kode_kelas']);
                        // concat 3
                        if ($tmp < count($jadwal)) {
                            if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                                $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                                $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                                $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                $j++;
                                $tmp++;
                                // concat 4
                                if ($tmp < count($jadwal)) {
                                    if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                                        $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                                        $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                        $j++;
                                        $tmp++;
                                        // concat 5
                                        if ($tmp < count($jadwal)) {
                                            if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                                                $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                                                $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                                                $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                                $j++;
                                                $tmp++;
                                                // concat 6
                                                if ($tmp < count($jadwal)) {
                                                    if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                                                        $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                                                        $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                                                        $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                                        $j++;
                                                        $tmp++;
                                                        // concat 7
                                                        if ($tmp < count($jadwal)) {
                                                            if ($arrJadwal[$i]['kode_kelas'] == $jadwal[$tmp]['kode_kelas'] && $arrJadwal[$i]['tanggal'] == $jadwal[$tmp]['tanggal']) {
                                                                $arrJadwal[$i]['concat_kode_jam'] = $arrJadwal[$i]['concat_kode_jam'] . '-' . $jadwal[$tmp]['id'];
                                                                $arrJadwal[$i]['concat_jam'] = $arrJadwal[$i]['concat_jam'] . '/' . $jadwal[$tmp]['kode_jam'];
                                                                $arrJadwal[$i]['kode_jam'][$jadwal[$tmp]['id']] = $jadwal[$tmp]['kode_jam'];
                                                                $j++;
                                                                $tmp++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $i++;
            }
            return response()->json([
                'status' => '200',
                // 'jadwal' => $jadwal
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
    public function update(Request $request, Jadwal $jadwal)
    {
        //
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
