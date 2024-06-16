<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\BidanDashboardController;
use App\Http\Controllers\JadwalPraktekController;
use App\Http\Controllers\JamPraktekController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PasienDashboardController;
use App\Http\Controllers\ReservasiBidanController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/service', [WebsiteController::class, 'service'])->name('website.service');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('website.contact');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('bidan', BidanController::class);
    Route::resource('jam_praktek', JamPraktekController::class);

    Route::get('/admin_dashboard/dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard.dashboard');
    // Rute lain untuk admin
});

Route::middleware(['auth', 'role:Pasien'])->group(function () {
    Route::get('/pasien_dashboard/dashboard', [PasienDashboardController::class, 'index'])->name('pasien_dashboard.dashboard');

    // Rute lain untuk pasien
});

Route::middleware(['auth', 'role:Bidan'])->group(function () {
    Route::get('/bidan_dashboard/dashboard', [BidanDashboardController::class, 'index'])->name('bidan_dashboard.dashboard');
    // Rute lain untuk bidan
});

Route::middleware(['auth', 'role:Admin,Bidan'])->group(function () {
    Route::get('/jadwal_praktek/create', [JadwalPraktekController::class, 'create'])->name('jadwal_praktek.create');
    Route::post('/jadwal_praktek/store', [JadwalPraktekController::class, 'store'])->name('jadwal_praktek.store');
    Route::get('jadwal_praktek/{jadwal_praktek}/edit', [JadwalPraktekController::class, 'edit'])->name('jadwal_praktek.edit');
    Route::put('jadwal_praktek/{jadwal_praktek}', [JadwalPraktekController::class, 'update'])->name('jadwal_praktek.update');
    Route::delete('jadwal_praktek/{jadwal_praktek}', [JadwalPraktekController::class, 'destroy'])->name('jadwal_praktek.destroy');
    Route::get('jadwal_praktek/{jadwal_praktek}', [JadwalPraktekController::class, 'show'])->name('jadwal_praktek.show');

    Route::delete('reservasi/{id}', [ReservasiBidanController::class, 'destroy'])->name('reservasi.destroy');

    // Rute lain untuk bidan
});

Route::middleware(['auth', 'role:Admin,Bidan,Pasien'])->group(function () {
    Route::get('praktek_bidan/index', [JadwalPraktekController::class, 'index'])->name('praktek_bidan.index');
    Route::get('praktek_bidan/index_history', [JadwalPraktekController::class, 'index_history'])->name('praktek_bidan.index_history');

    Route::get('/reservasi/create/{jadwalPraktekId}', [ReservasiBidanController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi/store/{jadwalPraktekId}', [ReservasiBidanController::class, 'store'])->name('reservasi.store');
    Route::get('reservasi/{id}/edit', [ReservasiBidanController::class, 'edit'])->name('reservasi.edit');
    Route::put('reservasi/{id}', [ReservasiBidanController::class, 'update'])->name('reservasi.update');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
