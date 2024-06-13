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
    Route::resource('jadwal_praktek', JadwalPraktekController::class);
    Route::get('jadwal_praktek/{id}/pasien', [JadwalPraktekController::class, 'getPasienByJadwal'])->name('jadwal_praktek.getPasienByJadwal');

    // Rute lain untuk bidan
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
