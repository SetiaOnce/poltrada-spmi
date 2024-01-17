<?php

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\Rules\Admin\AdminController;
use App\Http\Controllers\Backend\Rules\Admin\DataJenisKegiatanController;
use App\Http\Controllers\Backend\Rules\Admin\DataJenisPeraturanController;
use App\Http\Controllers\Backend\Rules\Admin\DataJenisProdukController;
use App\Http\Controllers\Backend\Rules\Admin\DataJenisSurveyController;
use App\Http\Controllers\Backend\Rules\Admin\DataLembagaAkreditasiController;
use App\Http\Controllers\Backend\Rules\Admin\DataSdmController;
use App\Http\Controllers\Backend\Rules\Admin\DataUnitPordiController;
use App\Http\Controllers\Backend\Rules\Admin\PenggunaController;
use App\Http\Controllers\Backend\Rules\Admin\SubJenisProdukController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix"=>"admin"
], function() {
    Route::get('/ajax-pie-cart/{id}', [AdminController::class, 'ajaxPieCart'])->name('admin.ajax.pie.cart');
    Route::get('/ajax-get-persentase-angkatan', [AdminController::class, 'ajaxGetPersentaseAngkatan'])->name('admin.ajax.get.persentase.angkatan');
    Route::get('/ajax-get-persentase-prodi', [AdminController::class, 'ajaxGetPersentaseProdi'])->name('admin.ajax.get.persentase.prodi');
    Route::get('/ajax-trend-audit', [AdminController::class, 'ajaxtrendAudit'])->name('admin.ajax.trend.audit');
    Route::get('/ajax-detail-trend-audit', [AdminController::class, 'ajaxtrendDetailAudit'])->name('admin.ajax.detail.trend.audit');
    // tabulasi
    Route::get('/ajax-jml-ya-tidak/{id}', [AdminController::class, 'ajaxJumlahYaTidak'])->name('admin.ajax.jml.ya.yidak');
    Route::get('/ajax-jml-1-4/{id}', [AdminController::class, 'ajaxJumlahSatuEmpat'])->name('admin.ajax.jml.pertanyaan.1.4');

    Route::post('/export-pdf', [AdminController::class, 'ExportPDF'])->name('admin.export.persentase.pdf');
    Route::get('/download-manual-book', [AdminController::class, 'DownloadManualBook'])->name('admin.download.manual.book');
    
    Route::get('/profile', [AdminController::class, 'Profile'])->name('admin.profile');
    Route::get('/profile-sinkronisasi', [AdminProfileController::class, 'SinkronisasiData'])->name('admin.sinkronisasi.data');
    Route::post('/profile-reset-password', [AdminProfileController::class, 'ProfileResetPassword'])->name('admin.profile.reset.password');

    // data sdm
    Route::resource('/data-sdm', DataSdmController::class);
    Route::get('/ajax-data-sdm', [DataSdmController::class, 'ajaxdatasdm'])->name('ajax.data.sdm');
    Route::get('/ajax-data-sdm-sinkron', [DataSdmController::class, 'AjaxDatasdmSinkron'])->name('ajax.data.sdm.sinkron');
    
    // data pengguna
    Route::resource('/pengguna', PenggunaController::class);
    Route::get('/ajax-get-data-sdm/{id}', [PenggunaController::class, 'AjaxGetDataSdm'])->name('ajax.get.data.sdm');

    // data unit/prodi
    Route::resource('/data-unit-prodi', DataUnitPordiController::class);
    
    // data jenis produk
    Route::resource('/data-jenis-produk', DataJenisProdukController::class);

    // data sub jenis produk
    Route::get('/sub-jenis-produk/{id}', [SubJenisProdukController::class, 'index'])->name('sub.jenis.produk.index');
    
    Route::resource('/sub-jenis-produk', SubJenisProdukController::class);

    // data jenis peraturan
    Route::resource('/data-jenis-peraturan', DataJenisPeraturanController::class);
    
    // data jenis survey
    Route::resource('/data-jenis-survey', DataJenisSurveyController::class);

    // data jenis kegiatan
    Route::resource('/data-jenis-kegiatan', DataJenisKegiatanController::class);

    // data lemabaga akreditasi
    Route::resource('/data-lembaga-akreditasi', DataLembagaAkreditasiController::class);

});