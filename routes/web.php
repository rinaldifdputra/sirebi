<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
