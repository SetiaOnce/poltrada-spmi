<?php

use App\Http\Controllers\Backend\Rules\Admin\BannerController;
use App\Http\Controllers\Backend\Rules\Admin\LinkAplikasiController;
use App\Http\Controllers\Backend\Rules\Admin\ManualBookController;
use App\Http\Controllers\Backend\Rules\Admin\PengumumanController;
use App\Http\Controllers\Backend\Rules\Admin\ProfileAppController;
use App\Http\Controllers\Backend\Rules\Admin\ProfileSpmiController;
use Illuminate\Support\Facades\Route;

// konten banner
Route::resource('/banner', BannerController::class);
Route::get('/banner/edit-status/{id}', [BannerController::class, 'ubahStatus']);
// profile-spmi
Route::resource('/profile-spmi', ProfileSpmiController::class);
Route::post('/visi-misi-update', [ProfileSpmiController::class, 'VisiMisiUpdate'])->name('visi.misi.update');
Route::post('/struktur-organisasi-update', [ProfileSpmiController::class, 'StrukturOrganisasi'])->name('struktur.organisasi.update');
Route::post('/fungsi-tugas-update', [ProfileSpmiController::class, 'FungsiTugasUpdate'])->name('fungsi.tugas.update');
// link app
Route::resource('/link-app', LinkAplikasiController::class);
// profile app
Route::resource('/profile-app', ProfileAppController::class);
// pengumuman
Route::resource('/pengumuman', PengumumanController::class);
Route::get('/pengumuman/edit-status/{id}', [PengumumanController::class, 'ubahStatus']);
// manual book
Route::resource('/manual-book', ManualBookController::class);