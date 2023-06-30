<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;


class JadwalavailableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $maxCount = $request->count_time;

        if (strtoupper($request->type) == 'SEMENTARA') {
            //selet all data
            try {
                if (isset($request->kode_ruangan) && $request->kode_ruangan != '-') {
                    $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                    ->whereNull('jadwal.kode_dosen')
                    // ->whereNotNull('jadwal.kode_ruangan')
                    ->where('jadwal.kode_ruangan', '=', $request->kode_ruangan)
                    ->get();
                } else {
                    if (isset($request->kode_lokasi) && $request->kode_lokasi != '-') {
                        if (isset($request->kode_gedung) && $request->kode_gedung != '-') {
                            if (isset($request->kode_lantai) && $request->kode_lantai != '-') {
                                $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                        ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                        ->whereNull('jadwal.kode_dosen')
                                        ->whereNotNull('jadwal.kode_ruangan')
                                        ->where('ref_ruangan.lokasi', '=', $request->kode_lokasi)
                                        ->where('ref_ruangan.gedung', '=', $request->kode_gedung)
                                        ->where('ref_ruangan.lantai', '=', $request->kode_lantai)
                                        ->get();
                            } else {
                                $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                        ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                        ->whereNull('jadwal.kode_dosen')
                                        ->whereNotNull('jadwal.kode_ruangan')
                                        ->where('ref_ruangan.lokasi', '=', $request->kode_lokasi)
                                        ->where('ref_ruangan.gedung', '=', $request->kode_gedung)
                                        ->get();
                            }
                        } else {
                            $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                    ->whereNull('jadwal.kode_dosen')
                                    ->whereNotNull('jadwal.kode_ruangan')
                                    ->where('ref_ruangan.lokasi', '=', $request->kode_lokasi)
                                    ->get();
                        }
                    } else {
                        $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                ->whereNull('jadwal.kode_dosen')
                                ->whereNotNull('jadwal.kode_ruangan')
                                // ->limit(10)
                                ->get();
                    }
                }
            
                $arrJadwal = [];
                $length = count($jadwalavailable);
                $i = 0;
                for ($j = 0; $j < $length; $j++) {
                    $arrJadwal[$i]['kode_kelas'] = $jadwalavailable[$j]['kode_kelas'];
                    $arrJadwal[$i]['kode_dosen'] = $jadwalavailable[$j]['kode_dosen'];
                    $arrJadwal[$i]['dosen'] = $jadwalavailable[$j]['dosen'];
                    $arrJadwal[$i]['kode_matkul'] = $jadwalavailable[$j]['kode_matkul'];
                    $arrJadwal[$i]['matkul'] = $jadwalavailable[$j]['matkul'];
                    $arrJadwal[$i]['pertemuan'] = $jadwalavailable[$j]['pertemuan'];
                    $arrJadwal[$i]['kode_ruangan'] = $jadwalavailable[$j]['kode_ruangan'];
                    $arrJadwal[$i]['hari'] = $jadwalavailable[$j]['hari'];
                    $arrJadwal[$i]['tanggal'] = $jadwalavailable[$j]['tanggal'];
                    $arrJadwal[$i]['concat_kode_jam'] = $jadwalavailable[$j]['id'];
                    $arrJadwal[$i]['concat_jam'] = $jadwalavailable[$j]['kode_jam'];
                    $arrJadwal[$i]['kode_jam'] = [$jadwalavailable[$j]['id'] => $jadwalavailable[$j]['kode_jam']];
                    $arrJadwal[$i]['ket_jadwal'] = $jadwalavailable[$j]['ket_jadwal'];
        
                    $tmp = $j + 1; // Start the inner loop from the next index
                    $setCount = 1;
                    while ( $setCount < $maxCount && $tmp < $length && $arrJadwal[$i]['kode_ruangan'] == $jadwalavailable[$tmp]['kode_ruangan'] && $arrJadwal[$i]['tanggal'] == $jadwalavailable[$tmp]['tanggal']) {
                        // Validate next kode_jam must increment
                        $cekNextJam = $jadwalavailable[$j]['kode_jam'] + $setCount;
                        if ($cekNextJam == $jadwalavailable[$tmp]['kode_jam']) {
                            $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwalavailable[$tmp]['id'];
                            $arrJadwal[$i]['concat_jam'] .= '/' . $jadwalavailable[$tmp]['kode_jam'];
                            $arrJadwal[$i]['kode_jam'][$jadwalavailable[$tmp]['id']] = $jadwalavailable[$tmp]['kode_jam'];
                            $tmp++;
                            $setCount++;
                        } else {
                            break;
                        }
                    }
                    // $j = $tmp - 1;
                    $i++;
                }
        
                $resultArrJadwal = [];
                // Remove kode_jam not match array with count_time
                foreach ($arrJadwal as $key => $value) {
                    $cekCountArr = count($value['kode_jam']);
                    if ($cekCountArr == $maxCount) {
                        array_push($resultArrJadwal, $value);
                    }
                }
        
                return response()->json([
                    'status' => '200',
                    'jadwalavailable' => $resultArrJadwal
                ]);

            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
            }
        } elseif (strtoupper($request->type) == 'PERMANEN') {
            # code...
        } else {
            $error = [
                'error' => 'Type is required!'
            ];
            return response()->json($error);
        }




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
