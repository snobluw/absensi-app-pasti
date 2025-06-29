<?php

use App\Models\Guru;
use App\Models\Admin;
use App\Models\KategoriAbsensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruPinjamanController;
use App\Http\Controllers\KategoriAbsensiController;
use App\Http\Controllers\PengembalianPinjamanController;

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

Route::get('/slip-gaji/download', [SlipGajiController::class, 'download'])->name('slip-gaji.download');
Route::get('/pinjaman/download-surat', [PinjamanController::class, 'downloadSurat'])->name('pinjaman.downloadSurat');


Route::get('/pinjaman/{pinjaman}', [GuruPinjamanController::class, 'show'])->name('guru.pinjaman.show');


//admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('admin/pinjaman', [PinjamanController::class, 'index'])->name('admin.pinjaman.index');
    Route::get('admin/pinjaman/create', [PinjamanController::class, 'create'])->name('admin.pinjaman.create');
    Route::post('admin/pinjaman', [PinjamanController::class, 'store'])->name('admin.pinjaman.store');
    Route::get('admin/pinjaman/{pinjaman}', [PinjamanController::class, 'show'])->name('admin.pinjaman.show');
    Route::post('admin/pinjaman/{pinjaman}/pengembalian', [PengembalianPinjamanController::class, 'store'])->name('admin.pinjaman.pengembalian.store');

    Route::put('admin/pinjaman/{pinjaman}/update-status/{status}', [PinjamanController::class, 'updateStatus'])->name('admin.pinjaman.update.status');

    Route::delete('admin/pinjaman/{pinjaman}', [PinjamanController::class, 'destroy'])->name('admin.pinjaman.destroy');

    Route::get('/check-absen-status', [AbsensiController::class, 'checkStatus'])->name('absensi.check-status');


    // Data Guru Routes
    Route::resource('/guru', GuruController::class);
    // Data Kategori Absensi Routes
    Route::get('/absensi-pilih-kategori', [AbsensiController::class, 'indexKategori']);
    // Data Kategori Absensi Routes
    Route::resource('/kategori-absensi', KategoriAbsensiController::class);
    // Data Admin Routes
    Route::resource('/admin', AdminController::class);

    Route::put('/absensi/{absensi:id}/validate', [AbsensiController::class, 'validateAbsensi']);
    Route::put('/absensi/{absensi}/validate', [AbsensiController::class, 'validateAbsen'])->name('absensi.validate');

    Route::get('/absensi/guru/{guru}', [AbsensiController::class, 'show'])->name('absensi.guru.show');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile-settings', [ProfileController::class, 'updateSettings'])->name('profile.settings');
});


Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::resource('/absensi', AbsensiController::class);
});

Route::get('/slip-gaji/{guru}', [SlipGajiController::class, 'index'])->middleware('auth');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/check-username', [UserController::class, 'checkUsername'])->name('check.username');

Route::get('/pinjaman', [PinjamanController::class, 'index'])->name('pinjaman.index');
