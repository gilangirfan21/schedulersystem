<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Ruangan;
use App\Models\Jadwal;

class LokasiController extends Controller
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
            try {
                $lokasi = Jadwal::leftJoin('ref_ruangan', 'jadwal.kode_ruangan', '=', 'ref_ruangan.kode')
                        ->select('ref_ruangan.lokasi')
                        ->whereNull('jadwal.kode_dosen')
                        ->whereNotNull('ref_ruangan.lokasi')
                        ->groupBy('ref_ruangan.lokasi')
                        ->get();
                return response()->json($lokasi);
            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
            }
        } else {
            // GENERAL DATA LOKASI
            try {
                $lokasi = Ruangan::select('lokasi')
                        ->groupBy('lokasi')
                        ->get();
                return response()->json($lokasi);
            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
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
