<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class RuanganController extends Controller
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
        if (strtoupper($request->available) == 'Y') {
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                if (isset($request->kodeGedung) && $request->kodeGedung != '-') {
                    if (isset($request->kodeLantai) && $request->kodeLantai != '-') {
                        try {
                            // SELECT BY LOKASI, GEDUNG, LANTAI
                            $ruangan = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                    ->select('ref_ruangan.kode')
                                    ->whereNull('jadwal.kode_dosen')
                                    ->whereNotNull('jadwal.kode_ruangan')
                                    ->where('ref_ruangan.lokasi', '=', $request->kodeLokasi)
                                    ->where('ref_ruangan.gedung', '=', $request->kodeGedung)
                                    ->where('ref_ruangan.lantai', '=', $request->kodeLantai)
                                    ->groupBy('ref_ruangan.kode')
                                    ->get();
                            return response()->json([
                                'status' => '200',
                                'ruangan' => $ruangan
                            ]);
                        } catch (QueryException $e) {
                            $error = [
                                'error' => $e->getMessage()
                            ];
                            return response()->json($error);
                        }
                    } else {
                        try {
                            // SELECT BY LOKASI, GEDUNG
                            $ruangan = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                                    ->select('ref_ruangan.kode')
                                    ->whereNull('jadwal.kode_dosen')
                                    ->whereNotNull('jadwal.kode_ruangan')
                                    ->where('ref_ruangan.lokasi', '=', $request->kodeLokasi)
                                    ->where('ref_ruangan.gedung', '=', $request->kodeGedung)
                                    ->groupBy('ref_ruangan.kode')
                                    ->get();
                            return response()->json([
                                'status' => '200',
                                'ruangan' => $ruangan
                            ]);
                        } catch (QueryException $e) {
                            $error = [
                                'error' => $e->getMessage()
                            ];
                            return response()->json($error);
                        }
                    }
                } else {
                    try {
                        // SELECT BY LOKASI
                        $ruangan = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                        ->select('ref_ruangan.kode')
                        ->whereNull('jadwal.kode_dosen')
                        ->whereNotNull('jadwal.kode_ruangan')
                        ->where('ref_ruangan.lokasi', '=', $request->kodeLokasi)
                        ->groupBy('ref_ruangan.kode')
                        ->get();
                        return response()->json([
                            'status' => '200',
                            'ruangan' => $ruangan
                        ]);
                    } catch (QueryException $e) {
                        $error = [
                            'error' => $e->getMessage()
                        ];
                        return response()->json($error);
                    }
                }
            } else {
                // all data ruangan
                try {
               // SELECT BY LOKASI
                $ruangan = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                ->select('ref_ruangan.kode')
                ->whereNull('jadwal.kode_dosen')
                ->whereNotNull('jadwal.kode_ruangan')
                ->groupBy('ref_ruangan.kode')
                ->get();
                return response()->json([
                    'status' => '200',
                    'ruangan' => $ruangan
                ]);
                } catch (QueryException $e) {
                    $error = [
                        'error' => $e->getMessage()
                    ];
                    return response()->json($error);
                }   
            }
        } else {
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                if (isset($request->kodeGedung) && $request->kodeGedung != '-') {
                    if (isset($request->kodeLantai) && $request->kodeLantai != '-') {
                        try {
                            $ruangan = Ruangan::select('kode', 'lokasi', 'gedung', 'lantai')
                                    ->where('lokasi','=', $request->kodeLokasi)
                                    ->where('gedung','=', $request->kodeGedung)
                                    ->where('lantai','=', $request->kodeLantai)
                                    ->get();
                            return response()->json([
                                'status' => '200',
                                'ruangan' => $ruangan
                            ]);
                        } catch (QueryException $e) {
                            $error = [
                                'error' => $e->getMessage()
                            ];
                            return response()->json($error);
                        }
                    } else {
                        try {
                            $ruangan = Ruangan::select('kode', 'lokasi', 'gedung', 'lantai')
                                    ->where('lokasi','=', $request->kodeLokasi)
                                    ->where('gedung','=', $request->kodeGedung)
                                    ->get();
                            return response()->json([
                                'status' => '200',
                                'ruangan' => $ruangan
                            ]);
                        } catch (QueryException $e) {
                            $error = [
                                'error' => $e->getMessage()
                            ];
                            return response()->json($error);
                        }
                    }
                } else {
                    try {
                        $ruangan = Ruangan::select('kode', 'lokasi', 'gedung', 'lantai')
                                ->where('lokasi','=', $request->kodeLokasi)
                                ->get();
                        return response()->json([
                            'status' => '200',
                            'ruangan' => $ruangan
                        ]);
                    } catch (QueryException $e) {
                        $error = [
                            'error' => $e->getMessage()
                        ];
                        return response()->json($error);
                    }
                }
            } else {
                // all data ruangan
                try {
                $ruangan = Ruangan::all();
                return response()->json([
                    'status' => '200',
                    'ruangan' => $ruangan
                ]);
                } catch (QueryException $e) {
                    $error = [
                        'error' => $e->getMessage()
                    ];
                    return response()->json($error);
                }   
            }
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
