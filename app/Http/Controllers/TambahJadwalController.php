<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Maatwebsite\Excel\Facades\Excel;

class TambahJadwalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        // $jadwal = Jadwal::all();
        $jadwal = Jadwal::limit(10)
                ->get();
        return view('tambahjadwal', ['jadwal' => $jadwal]);
    }

    public function export() {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }

    public function import() {
        Excel::import(new JadwalImport, request()->file('file'));
        return back();
    }
}
