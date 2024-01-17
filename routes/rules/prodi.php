<?php

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\Rules\Prodi\TargetNilaiMutuController;
use App\Http\Controllers\Backend\Rules\Prodi\ManajemenDataKegiatanController;
use App\Http\Controllers\Backend\Rules\Prodi\ManajemenDataPeraturanController;
use App\Http\Controllers\Backend\Rules\Prodi\ManajemenDataProdukController;
use App\Http\Controllers\Backend\Rules\Prodi\PengajuanAuditController;
use App\Http\Controllers\Backend\Rules\Prodi\PeriodeEvaluasiController;
use App\Http\Controllers\Backend\Rules\Prodi\ProdiController;

Route::group([
    "prefix"=>"prodi"
], function() {
    Route::get('/ajax-pie-cart/{id}', [ProdiController::class, 'ajaxPieCart'])->name('prodi.ajax.pie.cart');
    Route::get('/ajax-get-persentase-angkatan', [ProdiController::class, 'ajaxGetPersentaseAngkatan'])->name('prodi.ajax.get.persentase.angkatan');
    Route::get('/ajax-get-persentase-prodi', [ProdiController::class, 'ajaxGetPersentaseProdi'])->name('prodi.ajax.get.persentase.prodi');
    Route::get('/ajax-trend-audit', [ProdiController::class, 'ajaxtrendAudit'])->name('prodi.ajax.trend.audit');
    Route::get('/ajax-detail-trend-audit', [ProdiController::class, 'ajaxtrendDetailAudit'])->name('prodi.ajax.detail.trend.audit');
    // tabulasi
    Route::get('/ajax-jml-ya-tidak/{id}', [ProdiController::class, 'ajaxJumlahYaTidak'])->name('prodi.ajax.jml.ya.yidak');
    Route::get('/ajax-jml-1-4/{id}', [ProdiController::class, 'ajaxJumlahSatuEmpat'])->name('prodi.ajax.jml.pertanyaan.1.4');
    
    Route::post('/export-pdf', [ProdiController::class, 'ExportPDF'])->name('prodi.export.persentase.pdf');
    Route::get('/download-manual-book', [ProdiController::class, 'DownloadManualBook'])->name('prodi.download.manual.book');

    // profile all route
    Route::get('/profile', [ProdiController::class, 'Profile'])->name('prodi.profile');
    Route::get('/profile-sinkronisasi', [AdminProfileController::class, 'SinkronisasiData'])->name('prodi.sinkronisasi.data');
    Route::post('/profile-reset-password', [AdminProfileController::class, 'ProfileResetPassword'])->name('prodi.profile.reset.password');

    // manajemen data all route
    Route::prefix('manajemen-data')
    ->group(function() {
        Route::get('/produk', [ManajemenDataProdukController::class, 'index'])->name('prodi.porduk.index');
        Route::get('/peraturan', [ManajemenDataPeraturanController::class, 'index'])->name('prodi.peraturan.index');
        Route::get('/kegiatan', [ManajemenDataKegiatanController::class, 'index'])->name('prodi.kegiatan.index');
        Route::get('/kegiatan/{id}', [ManajemenDataKegiatanController::class, 'ajaxDetailKegiatan'])->name('prodi.detail.kegiatan');
    });
    
    // target nilai mutu
    Route::get('/taget-nilai-mutu', [TargetNilaiMutuController::class, 'index'])->name('prodi.porduk.nilai.mutu.index');
    // periode evaluasi
    Route::get('/periode-evaluasi', [PeriodeEvaluasiController::class, 'index'])->name('prodi.periode.evaluasi.index');
    Route::get('/ajax-detail-asesor/{id}', [PeriodeEvaluasiController::class, 'ajaxDetailAsesor'])->name('prodi.ajax.detail.asesor');

    // pengajuan audit all route
    Route::get('/pengajuan-audit', [PengajuanAuditController::class, 'index'])->name('prodi.pengajuan.audit.index');
    Route::get('/pengajuan-audit/edit/{id}', [PengajuanAuditController::class, 'edit'])->name('prodi.pengajuan.audit.edit');
    Route::post('/pengajuan-audit/add', [PengajuanAuditController::class, 'store'])->name('prodi.pengajuan.audit.store');
    Route::get('/ajax-get-standar-mutu/{id}', [PengajuanAuditController::class, 'ajaxgetStandarMutu'])->name('ajax.get.jenis.standar.mutu');
    Route::get('/ajax-ajukan-audit/{id}', [PengajuanAuditController::class, 'ajaxAjukanAudit'])->name('prodi.ajax.ajukan.audit');
    Route::get('/ajax-get-data-pendukung/{id}', [PengajuanAuditController::class, 'AjaxGetDataPendukung'])->name('ajax.get.data.pendukung');
    Route::post('/dokumen-pendukung/add', [PengajuanAuditController::class, 'DokumenPendukung'])->name('prodi.dokumen.pendukung.add');
    Route::delete('/dokumen-pendukung/delete/{id}', [PengajuanAuditController::class, 'destroy'])->name('prodi.dokumen.pendukung.destroy');
    Route::get('/ajax-get-detail-pengajuan/{id}', [PengajuanAuditController::class, 'AjaxdetailPengajuan'])->name('prodi.ajax.get.detail.pengajuan');
});