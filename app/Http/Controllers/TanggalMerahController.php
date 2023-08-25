<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanggalMerah;
use Illuminate\Support\Facades\Auth;

class TanggalMerahController extends Controller
{
    public function index(Request $request)
    {
        $listAccess = [1,2];
        if (in_array(Auth::user()->role, $listAccess)) {
            $tanggalMerah = TanggalMerah::all();
            return view('tanggalmerah', ['tanggalmerah' => $tanggalMerah]);
        } else {
            return view('home');
        }
    }

    public function tambah(Request $request) {
        $isExisting = TanggalMerah::where('tanggal_merah',$request->tanggal)->get();
        if ($isExisting) {
            TanggalMerah::create([
                'tanggal_merah' => $request->tanggal,
                'ket' => $request->keterangan
            ]);
            return redirect('/menu/tanggalmerah')->with('success','Berhasil menambah tanggal ' . $request->tanggal);
        } else {
            return redirect('/menu/tanggalmerah')->with('failed','Gagal menambahkan tanggal merah');

        }
    }

    public function Hapus(Request $request) {
        if ($request->tanggalmerah) {
            TanggalMerah::where('tanggal_merah', $request->tanggalmerah)->delete();
            return redirect('/menu/tanggalmerah')->with('success','Berhasil menghapus tanggal ' . $request->tanggalmerah);
        } else {
            return redirect('/menu/tanggalmerah')->with('failed','Gagal hapus tanggal merah');
        }
    }
}
