<?php

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\JsonController;
use App\Http\Controllers\Backend\Rules\Admin\AdminController;
use App\Http\Controllers\Backend\Rules\Asesor\AsesorController;
use App\Http\Controllers\Backend\Rules\Pengelola\PengelolaController;
use App\Http\Controllers\Backend\Rules\Prodi\ProdiController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Login All Route
Route::controller(LoginController::class)->group(function(){
    Route::get('/auth_login', 'index');
    Route::post('/ajax_login', 'login');
    Route::get('/load_login_site_info', 'loadLoginInfo');
});
Route::get('/logout', function () {
    Session::flush();
    return redirect('/auth_login'); 
});
Route::get('/reloadcaptcha', function () {
	return captcha_img();
});
// Frontend All Route //
Route::controller(FrontendController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/semua-kegiatan', 'SemuaKegiatan')->name('semua.kegiatan');
    Route::get('/kegiatan/baca/{id}', 'DetailKegiatan')->name('detail.kegiatan');
    Route::get('/profilespmi', 'ProfileSpmi')->name('profilespmi');
    Route::get('/produk', 'ProdukSpmi')->name('produk.index');
    Route::get('/akreditasi', 'AkreditasiSpmi')->name('akreditasi.index');
    Route::get('/survey', 'SurveySpmi')->name('survey.index');
    Route::get('/survey/{id}', 'DetailSurveySpmi')->name('survey.detail');
    Route::get('/ajax-get-produk/{id}', 'AjaxGetProduk')->name('ajax.get.produk');
});
// End Frontend All Route //
// Json All Route //
Route::controller(JsonController::class)->group(function(){
    Route::post('tinymce-upload', 'TinymceUpload')->name('tinymce.upload');
    // get produk controller
    Route::get('produk-get/{id}', 'getPorduk')->name('frontend.get.produk');
    // get peraturan controller
    Route::get('peraturan-get/{id}', 'getPeraturan')->name('frontend.get.peraturan');
    // cek notar
    Route::post('cek-notar', 'CekNotar')->name('survey.cek.notar');
    // cek email
    Route::post('cek-email', 'CekEmail')->name('survey.cek.email');
    // menyimpan survey dari frontend
    Route::post('/pertanyaan-survey/save', 'PertanyaanSurveySave')->name('pertanyaan.survey.save');
    // ajax pie schart
    Route::get('/ajax-pie-chart/{id}', 'ajaxPieCart')->name('front.ajax.pie.cart');
    Route::get('/ajax-get-persentase-angkatan', 'ajaxGetPersentaseAngkatan')->name('ajax.get.persentase.angkatan');
    Route::get('/ajax-get-persentase-prodi', 'ajaxGetPersentaseProdi')->name('ajax.get.persentase.prodi');
    // tabulasi
    Route::get('/ajax-jml-ya-tidak/{id}','ajaxJumlahYaTidak')->name('ajax.jml.ya.yidak');
    Route::get('/ajax-jml-1-4/{id}','ajaxJumlahSatuEmpat')->name('ajax.jml.pertanyaan.1.4');
});
// End Json All Route //
// profile 
Route::get('/profile', [AdminProfileController::class, 'index']);
require base_path('routes/rules/common.php');
Route::group(['middleware' => 'checkRole:spm-administrator'], function() {
    Route::get('/admin_dashboard', [AdminController::class, 'index'])->name('dashboard');
    require base_path('routes/rules/admin.php');
});
Route::group(['middleware' => 'checkRole:spm-unitprodi'], function() {
    Route::get('/prodi_dashboard', [ProdiController::class, 'index'])->name('dashboard');
    require base_path('routes/rules/prodi.php');
});
Route::group(['middleware' => 'checkRole:spm-asesor'], function() {
    Route::get('/asesor_dashboard', [AsesorController::class, 'index'])->name('dashboard');
    require base_path('routes/rules/Asesor.php');
});
Route::group(['middleware' => 'checkRole:spm-staff'], function() {
    Route::get('/pengelola_dashboard', [PengelolaController::class, 'index'])->name('dashboard');
    require base_path('routes/rules/pengelola.php');
});