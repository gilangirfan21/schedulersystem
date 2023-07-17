<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\TanggalMerah;
use App\Models\Tmpjadwal;

use function Ramsey\Uuid\v1;

class JadwalAvailableController extends Controller
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

        $dateNow = date('Y-m-d');
        // $dateNow = '2023-03-13';
        // tidak bisa memilih tanggal lebih kecil dari hari ini
        // if ($request->start_date < $dateNow) {
        //     $request->start_date = $dateNow;
        // }
        // if ($request->end_date < $dateNow) {
        //     $request->end_date = $dateNow;
        // }
        // dd($request->start_date);
        $maxCount = $request->count_time;
        $listIdAwal = $request->list_id;
        $listIdAwal = str_replace("/", "-", $listIdAwal);
        $listTanggalMerah = [];
        $queryTanggalMerah = TanggalMerah::select('tanggal_merah')
                        ->get();
        foreach ($queryTanggalMerah as $tanggal) {
            array_push($listTanggalMerah, $tanggal['tanggal_merah']);
        }
        
        // START CHECK LOKASI, GEDUNG, LANTAI, RUANGAN
        if (isset($request->kode_lokasi)) {
            $kodeLokasi = $request->kode_lokasi;
        }
        if (isset($request->kode_gedung)) {
            $kodeGedung = $request->kode_gedung;
        }
        if (isset($request->kode_lantai)) {
            $kodeLantai = $request->kode_lantai;
        }
        if (isset($request->kode_gedung)) {
            $kodeRuangan = $request->kode_ruangan;
        }
        // END CHECK LOKASI, GEDUNG, LANTAI, RUANGAN

        
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

                // tidak bisa memilih tanggal lebih kecil dari hari ini
                // $dataOri['tanggal'] = ( $dateNow <= $dataOri['tanggal']) ? $dataOri['tanggal'] : $dateNow;
            
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
                $kodeLokasiAwal = substr($dataOri['kode_ruangan'], 0, 1);
                $kodeGedungAwal = substr($dataOri['kode_ruangan'], 1, 1);
                $kodeLantaiAwal = substr($dataOri['kode_ruangan'], 2, 1);
                $kodeRuanganAwal = substr($dataOri['kode_ruangan'], 3, 1);
                if ($request->kode_lokasi != $kodeLokasiAwal || $request->kode_gedung != $kodeGedungAwal || $request->kode_lantai != $kodeLantaiAwal || $request->kode_ruangan != $kodeRuanganAwal) {
                    $resultArrJadwalTerdekat = [];
                }
                // dd($resultArrJadwalTerdekat);
                //** END SELECT JADWDAL TERDEKAT */


                //selet all data
                if (isset($request->kode_ruangan) && $request->kode_ruangan != '-') {
                    $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                    ->whereNull('jadwal.kode_dosen')
                    ->where('jadwal.kode_ruangan', '=', $request->kode_ruangan)
                    ->whereBetween('jadwal.tanggal', [$request->start_date, $request->end_date])
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
                                        ->whereBetween('jadwal.tanggal', [$request->start_date, $request->end_date])
                                        ->get();
                            } else {
                                $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                        ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                        ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                        ->whereNull('jadwal.kode_dosen')
                                        ->whereNotNull('jadwal.kode_ruangan')
                                        ->where('ref_ruangan.lokasi', '=', $request->kode_lokasi)
                                        ->where('ref_ruangan.gedung', '=', $request->kode_gedung)
                                        ->whereBetween('jadwal.tanggal', [$request->start_date, $request->end_date])
                                        ->get();
                            }
                        } else {
                            $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                    ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                    ->whereNull('jadwal.kode_dosen')
                                    ->whereNotNull('jadwal.kode_ruangan')
                                    ->where('ref_ruangan.lokasi', '=', $request->kode_lokasi)
                                    ->whereBetween('jadwal.tanggal', [$request->start_date, $request->end_date])
                                    ->get();
                        }
                    } else {
                        $jadwalavailable = Jadwal::leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                                ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                                ->leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                ->whereNull('jadwal.kode_dosen')
                                ->whereNotNull('jadwal.kode_ruangan')
                                ->whereBetween('jadwal.tanggal', [$request->start_date, $request->end_date])
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
                // Remove kode_jam not match array with count_time, sunday, and public holidays
                foreach ($arrJadwal as $jadwal) {
                    $cekCountArr = count($jadwal['kode_jam']);
                    if ($cekCountArr == $maxCount && (!in_array($jadwal['tanggal'], $listTanggalMerah)) && strtoupper($jadwal['hari']) != 'MINGGU' && $jadwal['concat_kode_jam'] != $listIdAwal) {
                        array_push($resultArrJadwal, $jadwal);
                    }
                }

                // merge array jadwal terdekat dan all jadawl available
                $mergedArray = array_merge($resultArrJadwalTerdekat, $resultArrJadwal);

                // $listtIdArr = array_column($mergedArray, 'concat_kode_jam');
                // // dd($listtIdArr);
                // $uniqArrayList = array_unique($listIdAwal);
                // dd($uniqArrayList);

                $resultArrJadwalFinal = collect($mergedArray)->unique()->values()->all();
                
        
                return response()->json([
                    'status' => '200',
                    'jadwalavailable' => $resultArrJadwalFinal
                ]);

            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
            }

        } elseif (strtoupper($request->type) == 'PERMANEN') {
            // code here
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
