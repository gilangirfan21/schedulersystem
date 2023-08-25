<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
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
        if(isset($request->kodeDosen) && $request->kodeDosen != '-') {
            $kode = $request->kodeDosen;
            try {
                $dosen = Dosen::where('kode','=',$kode)
                        ->first();
                return response()->json([
                    'status' => '200',
                    'dosen' => $dosen
                ]);
            } catch (QueryException $e) {
                $error = [
                    'error' => $e->getMessage()
                ];
                return response()->json($error);
            }
        } else {
            try {
                if (strtoupper($request->isRegisterd) == 'Y') {
                    $dosen = Dosen::orderBy('dosen', 'asc')
                            ->where('isRegisterd','=','Y')
                            ->get();
                } else if (strtoupper($request->isRegisterd) == 'N') {
                    $dosen = Dosen::orderBy('dosen', 'asc')
                            ->whereNull('isRegisterd')
                            ->get();
                } else {
                    $dosen = Dosen::orderBy('dosen', 'asc')
                            ->get();
                }
                return response()->json([
                    'status' => '200',
                    'dosen' => $dosen
                ]);
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
