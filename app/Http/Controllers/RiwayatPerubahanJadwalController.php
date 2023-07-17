<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPerubahanJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RiwayatPerubahanJadwalController extends Controller
{
    public function index(Request $request)
    {
        return view('riwayatperubahanjadwal');
    }
}
