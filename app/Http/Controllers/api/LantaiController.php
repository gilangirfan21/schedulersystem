<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class LantaiController extends Controller
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
        // SEPESIFIC AVAILABLE
        if (strtoupper($request->available) =='Y') {
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                if (isset($request->kodeGedung) && $request->kodeGedung != '-') {
                    try {
                        $lantai = Ruangan::select('lantai')
                                ->where('lokasi','=', $request->kodeLokasi)
                                ->where('gedung','=', $request->kodeGedung)
                                ->groupBy('lantai')
                                ->get();
                        return response()->json([
                            'status' => '200',
                            'lantai' => $lantai
                        ]);
                    } catch (QueryException $e) {
                        $error = [
                            'error' => $e->getMessage()
                        ];
                        return response()->json($error);
                    }
                }
            }
            $error = [
                'error' => 'kodeLokasi and kodeGedung are required'
            ];
            return response()->json($error);
        } else {
            // GENERAL
            if (isset($request->kodeLokasi) && $request->kodeLokasi != '-') {
                if (isset($request->kodeGedung) && $request->kodeGedung != '-') {
                    try {
                        $lantai = Ruangan::select('lantai')
                                ->where('lokasi','=', $request->kodeLokasi)
                                ->where('gedung','=', $request->kodeGedung)
                                ->groupBy('lantai')
                                ->get();
                        return response()->json([
                            'status' => '200',
                            'lantai' => $lantai
                        ]);
                    } catch (QueryException $e) {
                        $error = [
                            'error' => $e->getMessage()
                        ];
                        return response()->json($error);
                    }
                } else {
                    try {
                        $lantai = Ruangan::select('lantai')
                                ->where('lokasi','=', $request->kodeLokasi)
                                ->groupBy('lantai')
                                ->get();
                        return response()->json([
                            'status' => '200',
                            'lantai' => $lantai
                        ]);
                    } catch (QueryException $e) {
                        $error = [
                            'error' => $e->getMessage()
                        ];
                        return response()->json($error);
                    }
                }
            } else {
                // all data lantai
                try {
                $lantai = Ruangan::select('lantai')
                        ->groupBy('lantai')
                        ->get();
                return response()->json([
                    'status' => '200',
                    'lantai' => $lantai
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
