<?php

use App\Http\Controllers\api\DosenController;
use App\Http\Controllers\api\GedungController;
use App\Http\Controllers\API\JadwalavailableController;
use App\Http\Controllers\api\JadwalController;
use App\Http\Controllers\API\LantaiController;
use App\Http\Controllers\API\LokasiController;
use App\Http\Controllers\API\RuanganController;
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
    return $request->user();
});

// Route::post('/dosen','App\Http\Controllers\api\DosenController@show');
Route::post('/dosen', [DosenController::class, 'show']);
Route::post('/lokasi', [LokasiController::class, 'show']);
Route::post('/gedung', [GedungController::class, 'show']);
Route::post('/lantai', [LantaiController::class, 'show']);
Route::post('/ruangan', [RuanganController::class, 'show']);
Route::post('/jadwal', [JadwalController::class, 'show']);
Route::post('/jadwalavailable', [JadwalavailableController::class, 'show']);