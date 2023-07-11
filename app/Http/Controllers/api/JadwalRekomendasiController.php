<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\TanggalMerah;
use App\Models\Tmpjadwal;

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
        $listIdAwal = $request->list_id;
        $listIdAwal = str_replace("/", "-", $listIdAwal);
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
            //** START SELECT JADWDAL TERDEKAT */
            try {
                $dataOri = [];
                $listJadwalAwal = explode('/', $listIdAwal);
                for ($i=0; $i < count($listJadwalAwal); $i++) { 
                    $dataAwal = Jadwal::findOrFail($listJadwalAwal[$i]);
                    if (!count($dataOri)) {
                        $dataOri['tanggal'] = $dataAwal->tanggal;
                        $dataOri['kode_ruangan'] = $dataAwal->kode_ruangan;
                    }
                    $dataTmp = new Tmpjadwal();
                    // save data to tmp jadwal
                    $dataTmp->id = $dataAwal->id;
                    $dataTmp->kode_kelas = $dataAwal->kode_kelas;
                    $dataTmp->hari = $dataAwal->hari;
                    $dataTmp->tanggal = $dataAwal->tanggal;
                    $dataTmp->kode_matkul = $dataAwal->kode_matkul;
                    $dataTmp->pertemuan = $dataAwal->pertemuan;
                    $dataTmp->kode_ruangan = $dataAwal->kode_ruangan;
                    $dataTmp->kode_jam = $dataAwal->kode_jam;
                    $dataTmp->kode_dosen = $dataAwal->kode_dosen;
                    $dataTmp->ket_jadwal = $dataAwal->ket_jadwal;
                    $dataTmp->save();

                    // Remove from jadwal
                    $dataAwal->kode_kelas = null;
                    $dataAwal->kode_matkul = null;
                    $dataAwal->pertemuan = null;
                    $dataAwal->kode_dosen = null;
                    $dataAwal->ket_jadwal = null;
                    $dataAwal->save();
                    
                }
            
                $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                ->whereNull('jadwal.kode_dosen')
                ->where('jadwal.kode_ruangan', '=', $dataOri['kode_ruangan'])
                ->where('jadwal.tanggal', '=', $dataOri['tanggal'])
                ->get();
    
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
    
                for ($i=0; $i < count($listJadwalAwal); $i++) { 
                    $dataAwal = Jadwal::findOrFail($listJadwalAwal[$i]);
                    $dataTmp = Tmpjadwal::findOrFail($listJadwalAwal[$i]);
                    // restore data to jadwal
                    $dataAwal->kode_kelas = $dataTmp->kode_kelas;
                    $dataAwal->kode_matkul = $dataTmp->kode_matkul;
                    $dataAwal->pertemuan = $dataTmp->pertemuan;
                    $dataAwal->kode_dosen = $dataTmp->kode_dosen;
                    $dataAwal->ket_jadwal = $dataTmp->ket_jadwal;
                    $dataAwal->save();
                    // romove data form tmp jadwal
                    Tmpjadwal::where('id', $dataAwal->id)->delete();
                }
    
                $resultArrJadwalTerdekat = [];
                    // Remove kode_jam not match array with count_time, sunday, and public holidays
                    foreach ($arrJadwal as $jadwal) {
                        $cekCountArr = count($jadwal['kode_jam']);
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listIdAwal) {
                            array_push($resultArrJadwalTerdekat, $jadwal);
                        }
                    }
                //** END SELECT JADWDAL TERDEKAT */
                


            $kodeLokasi = substr($request->kode_ruangan, 0, 1);
            $kodeGedung = substr($request->kode_ruangan, 1, 1);
            //selet all data
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

                // Merge jadwal terbaik dengan rekomendasi terbaik
                $mergedArray = array_merge($resultArrJadwalTerdekat, $arrJadwal);
                $arrJadwal = collect($mergedArray)->unique()->values()->all();
        
                $tmpArrJadwal = [];
                // Remove kode_jam not match array with count_time, sunday, and public holidays
                foreach ($arrJadwal as $jadwal) {
                    $cekCountArr = count($jadwal['kode_jam']);
                    if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listJamArr) {
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
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listJamArr) {
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
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listJamArr) {
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
                        if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listJamArr) {
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
