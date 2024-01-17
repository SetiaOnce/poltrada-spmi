<?php

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\Rules\Asesor\AsesorController;
use App\Http\Controllers\Backend\Rules\Asesor\EvaluasiPengajuanAuditController;
use App\Http\Controllers\Backend\Rules\Asesor\ManajemenDataKegiatanController;
use App\Http\Controllers\Backend\Rules\Asesor\ManajemenDataPeraturanController;
use App\Http\Controllers\Backend\Rules\Asesor\ManajemenDataProdukController;
use App\Http\Controllers\Backend\Rules\Asesor\TargetNilaiMutuController;
use App\Http\Controllers\Backend\Rules\Asesor\PeriodeEvaluasiController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix"=>"asesor"
], function() {
    Route::get('/ajax-pie-cart/{id}', [AsesorController::class, 'ajaxPieCart'])->name('asesor.ajax.pie.cart');
    Route::get('/ajax-get-persentase-angkatan', [AsesorController::class, 'ajaxGetPersentaseAngkatan'])->name('asesor.ajax.get.persentase.angkatan');
    Route::get('/ajax-get-persentase-prodi', [AsesorController::class, 'ajaxGetPersentaseProdi'])->name('asesor.ajax.get.persentase.prodi');
    Route::get('/ajax-trend-audit', [AsesorController::class, 'ajaxtrendAudit'])->name('asesor.ajax.trend.audit');
    Route::get('/ajax-detail-trend-audit', [AsesorController::class, 'ajaxtrendDetailAudit'])->name('asesor.ajax.detail.trend.audit');
    // tabulasi
    Route::get('/ajax-jml-ya-tidak/{id}', [AsesorController::class, 'ajaxJumlahYaTidak'])->name('asesor.ajax.jml.ya.yidak');
    Route::get('/ajax-jml-1-4/{id}', [AsesorController::class, 'ajaxJumlahSatuEmpat'])->name('asesor.ajax.jml.pertanyaan.1.4');
    
    Route::post('/export-pdf', [AsesorController::class, 'ExportPDF'])->name('asesor.export.persentase.pdf');
    Route::get('/status-inbox-shange/{id}', [AsesorController::class, 'StatusInboxChange'])->name('asesor.status.inbox.change');
    Route::get('/inbox-lihat-semua', [AsesorController::class, 'InboxLihatSemua'])->name('asesor.inbox.lihat.semua');
    Route::get('/download-manual-book', [AsesorController::class, 'DownloadManualBook'])->name('asesor.download.manual.book');
    
    Route::get('/profile', [AsesorController::class, 'Profile'])->name('asesor.profile');
    Route::get('/profile-sinkronisasi', [AdminProfileController::class, 'SinkronisasiData'])->name('asesor.sinkronisasi.data');
    Route::post('/profile-reset-password', [AdminProfileController::class, 'ProfileResetPassword'])->name('asesor.profile.reset.password');
   
    Route::prefix('manajemen-data')
    ->group(function() {
        Route::get('/produk', [ManajemenDataProdukController::class, 'index'])->name('asesor.porduk.index');
        Route::get('/peraturan', [ManajemenDataPeraturanController::class, 'index'])->name('asesor.peraturan.index');
        Route::get('/kegiatan', [ManajemenDataKegiatanController::class, 'index'])->name('asesor.kegiatan.index');
        Route::get('/kegiatan/{id}', [ManajemenDataKegiatanController::class, 'ajaxDetailKegiatan'])->name('asesor.detail.kegiatan');
    });

    // target nilai mutu
    Route::get('/taget-nilai-mutu', [TargetNilaiMutuController::class, 'index'])->name('asesor.target.nilai.mutu.index');
    // periode evaluasi
    Route::get('/periode-evaluasi', [PeriodeEvaluasiController::class, 'index'])->name('asesor.periode.evaluasi.index');
    Route::get('/ajax-detail-asesor/{id}', [PeriodeEvaluasiController::class, 'ajaxDetailAsesor'])->name('asesor.ajax.detail.asesor');
    // evaluasi pengajuan audit
    Route::get('/evaluasi-audit', [EvaluasiPengajuanAuditController::class, 'index'])->name('asesor.evaluasi.audit');
    Route::get('/ajax-get-data-pendukung/{id}', [EvaluasiPengajuanAuditController::class, 'ajaxGetDataPendukung'])->name('asesor.ajax.get.data.pendukung');

    // daftar temuan all route
    Route::get('/ajax-get-daftar-temuan/{id}', [EvaluasiPengajuanAuditController::class, 'ajaxGetDaftarTemuan'])->name('asesor.ajax.get.daftar.temuan');
    Route::post('/ajax-add-temuan', [EvaluasiPengajuanAuditController::class, 'temuanStore'])->name('ajax.temuan.store');
    Route::get('/ajax-edit-temuan/{id}', [EvaluasiPengajuanAuditController::class, 'temuanEdit'])->name('ajax.temuan.edit');

    // daftar rekomendasi all route
    Route::get('/ajax-rekomendasi/{id}', [EvaluasiPengajuanAuditController::class, 'ajaxRekomendasi'])->name('asesor.ajax.get.rekomendasi');
    Route::post('/ajax-add-rekomendasi', [EvaluasiPengajuanAuditController::class, 'rekomendasiStore'])->name('ajax.rekomendasi.store');
    Route::get('/ajax-edit-rekomendasi/{id}', [EvaluasiPengajuanAuditController::class, 'rekomendasiEdit'])->name('ajax.rekomendasi.edit');
    
});