<?php

use App\Http\Controllers\api\DosenController;
use App\Http\Controllers\api\GedungController;
use App\Http\Controllers\api\JadwalController;
use App\Http\Controllers\API\JadwalAvailableController;
use App\Http\Controllers\API\JadwalRekomendasiController;
use App\Http\Controllers\API\LantaiController;
use App\Http\Controllers\API\LokasiController;
use App\Http\Controllers\API\RuanganController;
use App\Http\Controllers\API\TanggalMerahApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Route::post('/dosen','App\Http\Controllers\api\DosenController@show');
    
    return $request->user();
});

Route::post('/dosen', [DosenController::class, 'show']);
Route::post('/lokasi', [LokasiController::class, 'show']);
Route::post('/gedung', [GedungController::class, 'show']);
Route::post('/lantai', [LantaiController::class, 'show']);
Route::post('/ruangan', [RuanganController::class, 'show']);
Route::post('/jadwal', [JadwalController::class, 'show']);
Route::post('/jadwal/tanggalmerah', [JadwalController::class, 'jadwaltanggalmerah']); // riwayat perubahan jadwal
Route::post('/jadwal/tanggalmerah/popup', [JadwalController::class, 'jadwaltanggalmerahpopup']); // riwayat perubahan jadwal
// hapus semua jadwal di route web
Route::put('/jadwal', [JadwalController::class, 'update']);
Route::post('/jadwal/riwayat', [JadwalController::class, 'riwayat']); // riwayat perubahan jadwal
Route::post('/jadwalavailable', [JadwalAvailableController::class, 'show']);
Route::post('/jadwalrekomendasi', [JadwalRekomendasiController::class, 'show']);
Route::post('/tanggalmerah', [TanggalMerahApiController::class, 'show']);

