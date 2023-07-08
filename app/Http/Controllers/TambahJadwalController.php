<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportJadwal;
use App\Imports\ImportJadwal;
use App\Models\Jadwal;

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

    public function exportjadwal(Request $request) {
        return Excel::download(new ExportJadwal, 'jadwal.xlsx');
    }

    public function importjadwal(Request $request) {
        
        Excel::import(new ImportJadwal, $request->file('file')->store('files'));
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
}
