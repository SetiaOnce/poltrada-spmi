<?php

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\Rules\Pengelola\PengajuanAuditController;
use App\Http\Controllers\Backend\Rules\Pengelola\DaftarPenilaianController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataAkreditasiController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataAsesorController;
use App\Http\Controllers\Backend\Rules\Pengelola\EvenSurveyController;
use App\Http\Controllers\Backend\Rules\Pengelola\HasilSurveyController;
use App\Http\Controllers\Backend\Rules\Pengelola\JenisStandarMutuController;
use App\Http\Controllers\Backend\Rules\Pengelola\JenisSurveyController;
use App\Http\Controllers\Backend\Rules\Pengelola\LaporanAkhirController;
use App\Http\Controllers\Backend\Rules\Pengelola\LinkSurveyExternalController;
use App\Http\Controllers\Backend\Rules\Pengelola\ManajemenDataKegiatanController;
use App\Http\Controllers\Backend\Rules\Pengelola\ManajemenDataProdukController;
use App\Http\Controllers\Backend\Rules\Pengelola\NamaStandarMutuController;
use App\Http\Controllers\Backend\Rules\Pengelola\PengelolaController;
use App\Http\Controllers\Backend\Rules\Pengelola\PeriodeEvaluasiController;
use App\Http\Controllers\Backend\Rules\Pengelola\PertanyaanSurveyController;
use App\Http\Controllers\Backend\Rules\Pengelola\StandarMutuController;
use App\Http\Controllers\Backend\Rules\Pengelola\SubStandarMutuController;
use App\Http\Controllers\Backend\Rules\Pengelola\TargetNilaiMutuController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataJenisAkreditasiController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataJenisPeraturanController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataJenisProdukController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataJenisSurveyController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataLembagaAkreditasiController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataSdmController;
use App\Http\Controllers\Backend\Rules\Pengelola\DataUnitPordiController;
use App\Http\Controllers\Backend\Rules\Pengelola\StatusAkreditasiController;
use App\Http\Controllers\Backend\Rules\Pengelola\SubJenisProdukController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix"=>"pengelola"
], function() {
    Route::get('/ajax-pie-cart/{id}', [PengelolaController::class, 'ajaxPieCart'])->name('ajax.pie.cart');
    Route::get('/ajax-get-persentase-angkatan', [PengelolaController::class, 'ajaxGetPersentaseAngkatan'])->name('peng.ajax.get.persentase.angkatan');
    Route::get('/ajax-get-persentase-prodi', [PengelolaController::class, 'ajaxGetPersentaseProdi'])->name('peng.ajax.get.persentase.prodi');
    Route::get('/ajax-trend-audit', [PengelolaController::class, 'ajaxtrendAudit'])->name('peng.ajax.trend.audit');
    Route::get('/ajax-detail-trend-audit', [PengelolaController::class, 'ajaxtrendDetailAudit'])->name('peng.ajax.detail.trend.audit');
    // tabulasi
    Route::get('/ajax-jml-ya-tidak/{id}', [PengelolaController::class, 'ajaxJumlahYaTidak'])->name('peng.ajax.jml.ya.yidak');
    Route::get('/ajax-jml-1-4/{id}', [PengelolaController::class, 'ajaxJumlahSatuEmpat'])->name('peng.ajax.jml.pertanyaan.1.4');

    Route::post('/export-pdf', [PengelolaController::class, 'ExportPDF'])->name('pengelola.export.persentase.pdf');
    Route::get('/status-inbox-shange/{id}', [PengelolaController::class, 'StatusInboxChange'])->name('pengelola.status.inbox.change');
    Route::get('/inbox-lihat-semua', [PengelolaController::class, 'InboxLihatSemua'])->name('pengelola.inbox.lihat.semua');
    Route::get('/download-manual-book', [PengelolaController::class, 'DownloadManualBook'])->name('pengelola.download.manual.book');
    
    // data sdm
    Route::resource('/pengelola-data-sdm', DataSdmController::class);
    Route::get('/pengelola-ajax-data-sdm', [DataSdmController::class, 'ajaxdatasdm'])->name('pengelola.ajax.data.sdm');
    Route::get('/pengelola-ajax-data-sdm-sinkron', [DataSdmController::class, 'AjaxDatasdmSinkron'])->name('pengelola.ajax.data.sdm.sinkron');

    // data unit/prodi
    Route::resource('/pengelola-data-unit-prodi', DataUnitPordiController::class);
    
    // data jenis produk
    Route::resource('/pengelola-data-jenis-produk', DataJenisProdukController::class);

    // data sub jenis produk
    Route::get('/sub-jenis-produk/{id}', [SubJenisProdukController::class, 'index'])->name('peng.sub.jenis.produk.index');
    
    Route::resource('/peng-sub-jenis-produk', SubJenisProdukController::class);

    // data jenis peraturan
    Route::resource('/pengelola-data-jenis-peraturan', DataJenisPeraturanController::class);
    
    // data jenis survey
    Route::resource('/pengelola-data-jenis-survey', DataJenisSurveyController::class);

    // data jenis akreditasi
    Route::resource('/pengelola-data-jenis-akreditasi', DataJenisAkreditasiController::class);

    // data lemabaga akreditasi
    Route::resource('/pengelola-lembaga-akreditasi', DataLembagaAkreditasiController::class);
    
    // Manajemen data route
    Route::prefix('manajemen-data')
    ->group(function() {
        //manajemen data produk route
        Route::get('/produk', [ManajemenDataProdukController::class, 'index'])->name('pengelola.produk.index');
        Route::post('/produk-store', [ManajemenDataProdukController::class, 'store'])->name('pengelola.produk.store');
        Route::get('/produk-edit/{id}', [ManajemenDataProdukController::class, 'edit'])->name('pengelola.produk.edit');
        Route::delete('/produk-delete/{id}', [ManajemenDataProdukController::class, 'destroy'])->name('pengelola.produk.delete');
        Route::get('/get-sub-jenis-produk/{id}', [ManajemenDataProdukController::class, 'GetSubJenisProduk'])->name('ajax.get.sub.jenis.produk');

        //manajemen data status akreditasi route
        Route::get('/status-akreditasi', [StatusAkreditasiController::class, 'index'])->name('pengelola.statusakreditasi.index');
        Route::post('/status-akreditasi-store', [StatusAkreditasiController::class, 'store'])->name('pengelola.statusakreditasi.store');
        Route::get('/status-akreditasi-edit/{id}', [StatusAkreditasiController::class, 'edit'])->name('pengelola.statusakreditasi.edit');
        Route::delete('/status-akreditasi-delete/{id}', [StatusAkreditasiController::class, 'destroy'])->name('pengelola.statusakreditasi.delete');

        //manajemen data kegiatan route
        Route::get('/kegiatan', [ManajemenDataKegiatanController::class, 'index'])->name('pengelola.kegiatan.index');
        Route::post('/kegiatan-store', [ManajemenDataKegiatanController::class, 'store'])->name('pengelola.kegiatan.store');
        Route::get('/kegiatan-edit/{id}', [ManajemenDataKegiatanController::class, 'edit'])->name('pengelola.kegiatan.edit');
        Route::delete('/kegiatan-delete/{id}', [ManajemenDataKegiatanController::class, 'destroy'])->name('pengelola.kegiatan.delete');
        Route::get('/kegiatan/edit-status/{id}', [ManajemenDataKegiatanController::class, 'ubahStatus']);

    });

    Route::prefix('manajemen-mutu')
    ->group(function() {
        // standar mutu route
        Route::resource('/daftar-penilaian', DaftarPenilaianController::class);
        // periode evaluasi route
        Route::resource('/periode-evaluasi', PeriodeEvaluasiController::class);
        // target nilai mutu route
        Route::resource('/nilai-mutu', TargetNilaiMutuController::class);
        // daftar standar mutu route
        Route::resource('/standar-mutu', StandarMutuController::class);
        // data akreditasi
        Route::resource('/data-akreditasi', DataAkreditasiController::class);
        Route::get('/data-akreditasi-file-input/{id}', [DataAkreditasiController::class, 'fileInput'])->name('data_akreditasi_file_input');
        Route::post('/load-data-akreditasi-file-input', [DataAkreditasiController::class, 'datFileAkreditasi'])->name('load_data_akreditasi_file_input');
        Route::post('/data-akreditasi-file-input-save', [DataAkreditasiController::class, 'fileInputSave'])->name('data_akreditasi_file_input_save');
        Route::get('/data-akreditasi-file-input-destroyt/{id}', [DataAkreditasiController::class, 'fileInputDestroy'])->name('data_akreditasi_file_input_destroy');
        // jenis standar mutu route
        Route::get('/jenis-standar-mutu/{id}', [JenisStandarMutuController::class, 'index'])->name('jenis.standar.mutu.index');
        Route::post('/jenis-standar-mutu/store', [JenisStandarMutuController::class, 'store'])->name('jenis.standar.mutu.store');
        Route::get('/jenis-standar-mutu/edit/{id}', [JenisStandarMutuController::class, 'edit'])->name('jenis.standar.mutu.edit');

        // nama standar mutu route
        Route::get('/nama-standar-mutu/{id}', [NamaStandarMutuController::class, 'index'])->name('nama.standar.mutu.index');
        Route::post('/nama-standar-mutu/store', [NamaStandarMutuController::class, 'store'])->name('nama.standar.mutu.store');
        Route::get('/nama-standar-mutu/edit/{id}', [NamaStandarMutuController::class, 'edit'])->name('nama.standar.mutu.edit');

        Route::resource('/sub-standar-mutu', SubStandarMutuController::class);

        //Data asesor all route 
        Route::get('/data-asesor/{id}', [DataAsesorController::class, 'index'])->name('data.asesor.index');
        Route::post('/data-asesor/add', [DataAsesorController::class, 'store'])->name('data.asesor.index.store');
        Route::get('/data-asesor/edit/{id}', [DataAsesorController::class, 'edit'])->name('data.asesor.index.edit');
        Route::delete('/data-asesor/delete/{id}', [DataAsesorController::class, 'destroy'])->name('data.asesor.index.destroy');
    });

    Route::prefix('manajemen-survey')
    ->group(function() {
        // link survey external  all route
        Route::resource('/link-survey-external', LinkSurveyExternalController::class);
        Route::get('/link-survey-external/status/{id}',[LinkSurveyExternalController::class, 'ubahStatus'])->name('link.survey.change.status');
        // nama survey all route
        Route::resource('/jenis-sruvey', JenisSurveyController::class);
        Route::get('/duplikasi-survey/{id}', [JenisSurveyController::class, 'DuplikasiSurvey'])->name('nama-survey-duplikasi');
        Route::get('/kelola_pertanyaan_survey/{id}', [JenisSurveyController::class, 'KelolaPertanyaanSurvey'])->name('kelola-pertanyaan-survey');
        
        // pertanyaan survey all route
        Route::resource('/pertanyaan-survey', PertanyaanSurveyController::class);
        // event survey all route
        Route::resource('/even-survey', EvenSurveyController::class);
        // hasil survey all route
        Route::resource('/hasil-survey', HasilSurveyController::class);

        Route::get('/detail/{id}/hasil-survey/', [HasilSurveyController::class, 'DetailHasilSurvey'])->name('detail.hasil.survey');
        Route::post('/sub/hasil-survey/jawaban', [HasilSurveyController::class, 'SubHasilSurvey'])->name('sub.hasil.survey');
        // export data hasil survey
        Route::post('/hasil-survey/export-excel', [HasilSurveyController::class, 'HasilSurveyExportExcel'])->name('hasil.survey.export.excel');
    });

    // pengajuan audit all route
    Route::get('/pengajuan-audit', [PengajuanAuditController::class, 'index'])->name('pengelola.pengajuan.audit.index');
    Route::get('/ajax-get-data-pendukung/{id}', [PengajuanAuditController::class, 'ajaxGetDataPendukung'])->name('pengelola.ajax.get.data.pendukung');
    Route::get('/ajax-get-daftar-temuan/{id}', [PengajuanAuditController::class, 'ajaxGetDaftarTemuan'])->name('pengelola.ajax.get.daftar.temuan');
    // laporanakhir
    Route::get('/laporan-akhir/{id}', [LaporanAkhirController::class, 'index'])->name('pengelola.laporan.akhir');
    Route::post('/laporan-akhir/store', [LaporanAkhirController::class, 'store'])->name('pengelola.laporan.akhir.store');

    
});


