<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MahasiswaController;
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

    // Main Page
    Route::get('/home', [SchedulerController::class, 'index'])->name('home');
    Route::get('/home/search',[SchedulerController::class, 'index'])->name('home.search');
    
    // Default
    Route::view('about', 'about')->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Add new account
    Route::get('/daftar',[RegisterController::class, 'index'])->name('daftar');
    Route::post('/daftar',[RegisterController::class, 'index'])->name('tamabah');

    // check
    Route::get('check',[SchedulerController::class, 'check'])->name('check');

});

// Page for Mahasiswa
Route::get('/mahasiswa',[MahasiswaController::class, 'index'])->name('mahasiswa');
Route::get('/mahasiswa/search',[MahasiswaController::class, 'index'])->name('mahasiswa.search');
