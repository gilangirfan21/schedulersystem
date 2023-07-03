<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\TanggalMerah;

class JadwalRekomendasiController extends Controller
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
        $dafaultStartDate = '2000-01-01';
        $dafaultEndDate = '2100-12-31';
        // 4 Rekomendasi jadwal kosong
        $maxRekomandasi = 4;
        $listTanggalMerah = [];
        $queryTanggalMerah = TanggalMerah::select('tanggal_merah')
                        ->get();
        foreach ($queryTanggalMerah as $tanggal) {
            array_push($listTanggalMerah, $tanggal['tanggal_merah']);
        }

        // count_time
        $stringCount = strlen($request->list_jam);
        if ($stringCount > 2) {
            $listJamArr = explode('/', $request->list_jam);
            $maxCount = count($listJamArr);
        } else {
            $maxCount = 1;
        }

        $resultArrJadwal = [];
        if (strtoupper($request->type) == 'SEMENTARA') {
            $kodeLokasi = substr($request->kode_ruangan, 0, 1);
            $kodeGedung = substr($request->kode_ruangan, 1, 1);
            //selet all data
            try {
                // The Best Recommendation (Data sama lokasi, gedung, tanggal, jam)
                $jadwalRekomendasi = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                ->whereNull('jadwal.kode_dosen')
                ->where('ref_ruangan.lokasi', '=', $kodeLokasi)
                ->where('ref_ruangan.gedung', '=', $kodeGedung)
                ->where('jadwal.tanggal', '=', $request->tanggal)
                ->whereBetween('jadwal.tanggal', [$dafaultStartDate, $dafaultEndDate])
                ->get();

                $arrJadwal = [];
                $length = count($jadwalRekomendasi);
                $i = 0;
                for ($j = 0; $j < $length; $j++) {
                    $arrJadwal[$i]['kode_kelas'] = $jadwalRekomendasi[$j]['kode_kelas'];
                    $arrJadwal[$i]['kode_dosen'] = $jadwalRekomendasi[$j]['kode_dosen'];
                    $arrJadwal[$i]['dosen'] = $jadwalRekomendasi[$j]['dosen'];
                    $arrJadwal[$i]['kode_matkul'] = $jadwalRekomendasi[$j]['kode_matkul'];
                    $arrJadwal[$i]['matkul'] = $jadwalRekomendasi[$j]['matkul'];
                    $arrJadwal[$i]['pertemuan'] = $jadwalRekomendasi[$j]['pertemuan'];
                    $arrJadwal[$i]['kode_ruangan'] = $jadwalRekomendasi[$j]['kode_ruangan'];
                    $arrJadwal[$i]['hari'] = $jadwalRekomendasi[$j]['hari'];
                    $arrJadwal[$i]['tanggal'] = $jadwalRekomendasi[$j]['tanggal'];
                    $arrJadwal[$i]['concat_kode_jam'] = $jadwalRekomendasi[$j]['id'];
                    $arrJadwal[$i]['concat_jam'] = $jadwalRekomendasi[$j]['kode_jam'];
                    $arrJadwal[$i]['kode_jam'] = [$jadwalRekomendasi[$j]['id'] => $jadwalRekomendasi[$j]['kode_jam']];
                    $arrJadwal[$i]['ket_jadwal'] = $jadwalRekomendasi[$j]['ket_jadwal'];
        
                    $tmp = $j + 1; // Start the inner loop from the next index
                    $setCount = 1;
                    while ( $setCount < $maxCount && $tmp < $length && $arrJadwal[$i]['kode_ruangan'] == $jadwalRekomendasi[$tmp]['kode_ruangan'] && $arrJadwal[$i]['tanggal'] == $jadwalRekomendasi[$tmp]['tanggal']) {
                        // Validate next kode_jam must increment
                        $cekNextJam = $jadwalRekomendasi[$j]['kode_jam'] + $setCount;
                        if ($cekNextJam == $jadwalRekomendasi[$tmp]['kode_jam']) {
                            $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwalRekomendasi[$tmp]['id'];
                            $arrJadwal[$i]['concat_jam'] .= '/' . $jadwalRekomendasi[$tmp]['kode_jam'];
                            $arrJadwal[$i]['kode_jam'][$jadwalRekomendasi[$tmp]['id']] = $jadwalRekomendasi[$tmp]['kode_jam'];
                            $tmp++;
                            $setCount++;
                        } else {
                            break;
                        }
                    }
                    // $j = $tmp - 1;
                    $i++;
                }
        
                $tmpArrJadwal = [];
                // Remove kode_jam not match array with count_time, sunday, and public holidays
                foreach ($arrJadwal as $jadwal) {
                    $cekCountArr = count($jadwal['kode_jam']);
                    if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU') {
                        array_push($tmpArrJadwal, $jadwal);
                    }
                    if ($maxRekomandasi == count($tmpArrJadwal)) {
                        $resultArrJadwal = $tmpArrJadwal;
                        break;
                    }
                }

                // Step 2 Search Best Recommendation (Data sama lokasi, gedung, tanggal)
                if ($maxRekomandasi != count($resultArrJadwal)) {
                    $jadwalRekomendasi = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                    ->whereNull('jadwal.kode_dosen')
                    ->where('ref_ruangan.lokasi', '=', $kodeLokasi)
                    ->where('ref_ruangan.gedung', '=', $kodeGedung)
                    ->where('jadwal.tanggal', '=', $request->tanggal)
                    ->whereBetween('jadwal.tanggal', [$dafaultStartDate, $dafaultEndDate])
                    ->get();
                
                    $arrJadwal = [];
                    $length = count($jadwalRekomendasi);
                    $i = 0;
                    for ($j = 0; $j < $length; $j++) {
                        $arrJadwal[$i]['kode_kelas'] = $jadwalRekomendasi[$j]['kode_kelas'];
                        $arrJadwal[$i]['kode_dosen'] = $jadwalRekomendasi[$j]['kode_dosen'];
                        $arrJadwal[$i]['dosen'] = $jadwalRekomendasi[$j]['dosen'];
                        $arrJadwal[$i]['kode_matkul'] = $jadwalRekomendasi[$j]['kode_matkul'];
                        $arrJadwal[$i]['matkul'] = $jadwalRekomendasi[$j]['matkul'];
                        $arrJadwal[$i]['pertemuan'] = $jadwalRekomendasi[$j]['pertemuan'];
                        $arrJadwal[$i]['kode_ruangan'] = $jadwalRekomendasi[$j]['kode_ruangan'];
                        $arrJadwal[$i]['hari'] = $jadwalRekomendasi[$j]['hari'];
                        $arrJadwal[$i]['tanggal'] = $jadwalRekomendasi[$j]['tanggal'];
                        $arrJadwal[$i]['concat_kode_jam'] = $jadwalRekomendasi[$j]['id'];
                        $arrJadwal[$i]['concat_jam'] = $jadwalRekomendasi[$j]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'] = [$jadwalRekomendasi[$j]['id'] => $jadwalRekomendasi[$j]['kode_jam']];
                        $arrJadwal[$i]['ket_jadwal'] = $jadwalRekomendasi[$j]['ket_jadwal'];
            
                        $tmp = $j + 1; // Start the inner loop from the next index
                        $setCount = 1;
                        while ( $setCount < $maxCount && $tmp < $length && $arrJadwal[$i]['kode_ruangan'] == $jadwalRekomendasi[$tmp]['kode_ruangan'] && $arrJadwal[$i]['tanggal'] == $jadwalRekomendasi[$tmp]['tanggal']) {
                            // Validate next kode_jam must increment
                            $cekNextJam = $jadwalRekomendasi[$j]['kode_jam'] + $setCount;
                            if ($cekNextJam == $jadwalRekomendasi[$tmp]['kode_jam']) {
                                $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwalRekomendasi[$tmp]['id'];
                                $arrJadwal[$i]['concat_jam'] .= '/' . $jadwalRekomendasi[$tmp]['kode_jam'];
                                $arrJadwal[$i]['kode_jam'][$jadwalRekomendasi[$tmp]['id']] = $jadwalRekomendasi[$tmp]['kode_jam'];
                                $tmp++;
                                $setCount++;
                            } else {
                                break;
                            }
                        }
                        $i++;
                    }
            
                    $tmpArrJadwal = [];
                    // Remove kode_jam not match array with count_time, sunday, and public holidays
                    foreach ($arrJadwal as $jadwal) {
                        $cekCountArr = count($jadwal['kode_jam']);
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU') {
                            array_push($tmpArrJadwal, $jadwal);
                        }
                        if ($maxRekomandasi == count($tmpArrJadwal)) {
                            $resultArrJadwal = $tmpArrJadwal;
                            break;
                        }
                    }
                }

                // Step 3 Search Best Recommendation (Data sama lokasi, gedung)
                if ($maxRekomandasi != count($resultArrJadwal)) {
                    $jadwalRekomendasi = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                    ->whereNull('jadwal.kode_dosen')
                    ->where('ref_ruangan.lokasi', '=', $kodeLokasi)
                    ->where('ref_ruangan.gedung', '=', $kodeGedung)
                    ->whereBetween('jadwal.tanggal', [$dafaultStartDate, $dafaultEndDate])
                    ->get();
                
                    $arrJadwal = [];
                    $length = count($jadwalRekomendasi);
                    $i = 0;
                    for ($j = 0; $j < $length; $j++) {
                        $arrJadwal[$i]['kode_kelas'] = $jadwalRekomendasi[$j]['kode_kelas'];
                        $arrJadwal[$i]['kode_dosen'] = $jadwalRekomendasi[$j]['kode_dosen'];
                        $arrJadwal[$i]['dosen'] = $jadwalRekomendasi[$j]['dosen'];
                        $arrJadwal[$i]['kode_matkul'] = $jadwalRekomendasi[$j]['kode_matkul'];
                        $arrJadwal[$i]['matkul'] = $jadwalRekomendasi[$j]['matkul'];
                        $arrJadwal[$i]['pertemuan'] = $jadwalRekomendasi[$j]['pertemuan'];
                        $arrJadwal[$i]['kode_ruangan'] = $jadwalRekomendasi[$j]['kode_ruangan'];
                        $arrJadwal[$i]['hari'] = $jadwalRekomendasi[$j]['hari'];
                        $arrJadwal[$i]['tanggal'] = $jadwalRekomendasi[$j]['tanggal'];
                        $arrJadwal[$i]['concat_kode_jam'] = $jadwalRekomendasi[$j]['id'];
                        $arrJadwal[$i]['concat_jam'] = $jadwalRekomendasi[$j]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'] = [$jadwalRekomendasi[$j]['id'] => $jadwalRekomendasi[$j]['kode_jam']];
                        $arrJadwal[$i]['ket_jadwal'] = $jadwalRekomendasi[$j]['ket_jadwal'];
            
                        $tmp = $j + 1; // Start the inner loop from the next index
                        $setCount = 1;
                        while ( $setCount < $maxCount && $tmp < $length && $arrJadwal[$i]['kode_ruangan'] == $jadwalRekomendasi[$tmp]['kode_ruangan'] && $arrJadwal[$i]['tanggal'] == $jadwalRekomendasi[$tmp]['tanggal']) {
                            // Validate next kode_jam must increment
                            $cekNextJam = $jadwalRekomendasi[$j]['kode_jam'] + $setCount;
                            if ($cekNextJam == $jadwalRekomendasi[$tmp]['kode_jam']) {
                                $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwalRekomendasi[$tmp]['id'];
                                $arrJadwal[$i]['concat_jam'] .= '/' . $jadwalRekomendasi[$tmp]['kode_jam'];
                                $arrJadwal[$i]['kode_jam'][$jadwalRekomendasi[$tmp]['id']] = $jadwalRekomendasi[$tmp]['kode_jam'];
                                $tmp++;
                                $setCount++;
                            } else {
                                break;
                            }
                        }
                        $i++;
                    }
            
                    $tmpArrJadwal = [];
                    // Remove kode_jam not match array with count_time, sunday, and public holidays
                    foreach ($arrJadwal as $jadwal) {
                        $cekCountArr = count($jadwal['kode_jam']);
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU') {
                            array_push($tmpArrJadwal, $jadwal);
                        }
                        if ($maxRekomandasi == count($tmpArrJadwal)) {
                            $resultArrJadwal = $tmpArrJadwal;
                            break;
                        }
                    }
                }

                // Last Step Search(all jadwal kosong)
                if ($maxRekomandasi != count($resultArrJadwal)) {
                    $jadwalRekomendasi = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                    ->whereNull('jadwal.kode_dosen')
                    ->where('ref_ruangan.lokasi', '=', $kodeLokasi)
                    ->whereBetween('jadwal.tanggal', [$dafaultStartDate, $dafaultEndDate])
                    ->get();
                
                    $arrJadwal = [];
                    $length = count($jadwalRekomendasi);
                    $i = 0;
                    for ($j = 0; $j < $length; $j++) {
                        $arrJadwal[$i]['kode_kelas'] = $jadwalRekomendasi[$j]['kode_kelas'];
                        $arrJadwal[$i]['kode_dosen'] = $jadwalRekomendasi[$j]['kode_dosen'];
                        $arrJadwal[$i]['dosen'] = $jadwalRekomendasi[$j]['dosen'];
                        $arrJadwal[$i]['kode_matkul'] = $jadwalRekomendasi[$j]['kode_matkul'];
                        $arrJadwal[$i]['matkul'] = $jadwalRekomendasi[$j]['matkul'];
                        $arrJadwal[$i]['pertemuan'] = $jadwalRekomendasi[$j]['pertemuan'];
                        $arrJadwal[$i]['kode_ruangan'] = $jadwalRekomendasi[$j]['kode_ruangan'];
                        $arrJadwal[$i]['hari'] = $jadwalRekomendasi[$j]['hari'];
                        $arrJadwal[$i]['tanggal'] = $jadwalRekomendasi[$j]['tanggal'];
                        $arrJadwal[$i]['concat_kode_jam'] = $jadwalRekomendasi[$j]['id'];
                        $arrJadwal[$i]['concat_jam'] = $jadwalRekomendasi[$j]['kode_jam'];
                        $arrJadwal[$i]['kode_jam'] = [$jadwalRekomendasi[$j]['id'] => $jadwalRekomendasi[$j]['kode_jam']];
                        $arrJadwal[$i]['ket_jadwal'] = $jadwalRekomendasi[$j]['ket_jadwal'];
            
                        $tmp = $j + 1; // Start the inner loop from the next index
                        $setCount = 1;
                        while ( $setCount < $maxCount && $tmp < $length && $arrJadwal[$i]['kode_ruangan'] == $jadwalRekomendasi[$tmp]['kode_ruangan'] && $arrJadwal[$i]['tanggal'] == $jadwalRekomendasi[$tmp]['tanggal']) {
                            // Validate next kode_jam must increment
                            $cekNextJam = $jadwalRekomendasi[$j]['kode_jam'] + $setCount;
                            if ($cekNextJam == $jadwalRekomendasi[$tmp]['kode_jam']) {
                                $arrJadwal[$i]['concat_kode_jam'] .= '-' . $jadwalRekomendasi[$tmp]['id'];
                                $arrJadwal[$i]['concat_jam'] .= '/' . $jadwalRekomendasi[$tmp]['kode_jam'];
                                $arrJadwal[$i]['kode_jam'][$jadwalRekomendasi[$tmp]['id']] = $jadwalRekomendasi[$tmp]['kode_jam'];
                                $tmp++;
                                $setCount++;
                            } else {
                                break;
                            }
                        }
                        $i++;
                    }
            
                    $tmpArrJadwal = [];
                    // Remove kode_jam not match array with count_time, sunday, and public holidays
                    foreach ($arrJadwal as $jadwal) {
                        $cekCountArr = count($jadwal['kode_jam']);
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU') {
                            array_push($tmpArrJadwal, $jadwal);
                        }
                        if ($maxRekomandasi == count($tmpArrJadwal)) {
                            $resultArrJadwal = $tmpArrJadwal;
                            break;
                        }
                    }
                }

                // dd($resultArrJadwal);

        
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
