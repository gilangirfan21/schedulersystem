<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;
use App\Models\Jadwal;


class GedungController extends Controller
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
     * @param  \App\Models\Ruangan  $gedung
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (strtoupper($request->available) == 'Y') {
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                try {
                    $gedung = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                            ->select('ref_ruangan.gedung')
                            ->whereNull('jadwal.kode_dosen')
                            ->whereNotNull('ref_ruangan.gedung')
                            ->where('ref_ruangan.lokasi', '=', $request->kodeLokasi)
                            ->groupBy('ref_ruangan.gedung')
                            ->get();
                    return response()->json([
                        'status' => '200',
                        'gedung' => $gedung
                    ]);
                } catch (QueryException $e) {
                    $error = [
                        'error' => $e->getMessage()
                    ];
                    return response()->json($error);
                }   
            } else {
                try {
                $gedung = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                        ->select('ref_ruangan.gedung')
                        ->whereNull('jadwal.kode_dosen')
                        ->whereNotNull('ref_ruangan.lokasi')
                        ->whereNotNull('ref_ruangan.gedung')
                        ->groupBy('ref_ruangan.gedung')
                        ->get();
                return response()->json([
                    'status' => '200',
                    'gedung' => $gedung
                ]);
                } catch (QueryException $e) {
                    $error = [
                        'error' => $e->getMessage()
                    ];
                    return response()->json($error);
                }   
            }
        } else {
            //GENERAL DATA GEDUNG
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                try {
                    $gedung = Ruangan::select('gedung')
                            ->where('lokasi','=', $request->kodeLokasi)
                            ->groupBy('gedung')
                            ->get();
                    return response()->json([
                        'status' => '200',
                        'gedung' => $gedung
                    ]);
                } catch (QueryException $e) {
                    $error = [
                        'error' => $e->getMessage()
                    ];
                    return response()->json($error);
                }   
            } else {
                try {
                $gedung = Ruangan::select('gedung')
                        ->groupBy('gedung')
                        ->get();
                return response()->json([
                    'status' => '200',
                    'gedung' => $gedung
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
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruangan $ruangan)
    {
        //
    }
}
