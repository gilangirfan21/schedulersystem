<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\TambahJadwalController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\HapusJadwalController;
use App\Http\Controllers\TanggalMerahController;
use Illuminate\Console\Scheduling\Schedule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SchedulerController::class, 'index']);
Route::get('/login', function () {
    return view('login')->name('login');
});

// Route::get('/daftar', function () {
//     return view('auth.register');
// });


Auth::routes();
Route::middleware('auth')->group(function () {

    
    
    // Default
    Route::view('about', 'about')->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index'); //Menu (USERS)
    Route::get('user/edit/{uid}', [UserController::class, 'edit'])->name('user.edit'); //Halamn Edit (USER)
    Route::post('user/update/{uid}', [UserController::class, 'update'])->name('user.update'); //Update (USER)
    Route::get('user/resetpass/{uid}', [UserController::class, 'resetpass'])->name('user.resetpass'); //Reset Password (USER)
    Route::get('user/hapus/{uid}', [UserController::class, 'hapus'])->name('user.hapus'); //Hapus (USER)
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    // Add new account (DAFTAR)
    Route::get('/daftar',[RegisterController::class, 'index'])->name('daftar');
    Route::post('/daftar',[RegisterController::class, 'tambah'])->name('tambah');

    // LIST MENU
    // Main Page (JADWAL)
    Route::get('/home', [SchedulerController::class, 'index'])->name('home');
    Route::get('/home/search', [SchedulerController::class, 'index'])->name('home.search');
    Route::get('/menu/riwayatperubahanjadwal',[SchedulerController::class, 'riwayat'])->name('riwayatperubahanjadwal');
    Route::get('/menu/jadwaltanggalmerah', [SchedulerController::class, 'jadwaltanggalmerah'])->name('jadwaltanggalmerah');
    Route::get('/menu/tanggalmerah',[TanggalMerahController::class, 'index'])->name('tanggalmerah');
    Route::post('/tanggalmerah/tambah',[TanggalMerahController::class, 'tambah'])->name('tanggalmerah.tambah');
    Route::get('/tanggalmerah/hapus/{tanggalmerah}',[TanggalMerahController::class, 'hapus'])->name('tanggalmerah.hapus');
    // riwayat perubahan jadwal get by api
    

    
    // Export Schedule (TAMBAH JADWAL)
    Route::get('/exportjadwal', [TambahJadwalController::class, 'exportjadwal'])->name('exportjadwal');
    Route::post('/importjadwal', [TambahJadwalController::class, 'importjadwal'])->name('importjadwal');
    
    // Reschedule Manual 
    Route::get('/check',[SchedulerController::class, 'check'])->name('check');

    // Hapus Semua Jadwal
    Route::get('/jadwal/hapus',[HapusJadwalController::class, 'hapus'])->name('hapussemuajadwal');
    
});

// Page for Mahasiswa
Route::get('/mahasiswa',[MahasiswaController::class, 'index'])->name('mahasiswa');
Route::get('/mahasiswa/search',[MahasiswaController::class, 'index'])->name('mahasiswa.search');
