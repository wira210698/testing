<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/ibu/{id}/usia','ApiController@ubahUsia');
Route::post('/ibu/{id}/tanggal','ApiController@ubahTanggal');
Route::post('/ibu/{id}/ket','ApiController@ubahKeterangan');
Route::post('/ibu/{id}/tanggalPersalinan','ApiController@ubahTanggalP');
Route::post('/ibu/{id}/tngPenolong','ApiController@ubahPenolong');
Route::post('/ibu/{id}/jenisKelahiran','ApiController@ubahKelahiran');
Route::post('/ibu/{id}/tanggalNifas','ApiController@ubahTanggalNifas');
Route::post('/ibu/{id}/ketNifas','ApiController@ubahKetNifas');
Route::post('/ibu/{id}/periodeNifas','ApiController@ubahPeriode');

//Keluarga Berencana
Route::post('/KB/{id}/tanggalKB','ApiController@ubahTanggalKB');
Route::post('/KB/{id}/kategoriKB','ApiController@ubahKategoriKB');
Route::post('/KB/{id}/jenisKB','ApiController@ubahJenisKB');
Route::post('/KB/{id}/ketKB','ApiController@ubahKetKB');

//anak
//Kunjungan
Route::post('/anak/{id}/tanggalAnak','ApiController@ubahTanggalAnak');
Route::post('/anak/{id}/kdPelayanan','ApiController@ubahKdPelayanan');
Route::post('/anak/{id}/tempat','ApiController@ubahTempatP');
Route::post('/anak/{id}/umur','ApiController@ubahUmurAnak');
Route::post('/anak/{id}/bb','ApiController@ubahBBAnak');
Route::post('/anak/{id}/kondisi','ApiController@ubahKondisiAnak');
Route::post('/anak/{id}/ketAnak','ApiController@ubahKetAnak');

// Prasekolah
Route::post('/anak/{id}/tanggalPelayanan','ApiController@ubahTanggalPelayanan');
Route::post('/anak/{id}/tempatP','ApiController@ubahTempatPrasekolah');
Route::post('/anak/{id}/giziP','ApiController@ubahGiziP');
Route::post('/anak/{id}/arvP','ApiController@ubahArvP');

// Lahir
Route::post('/anak/{id}/tanggalPelayananL','ApiController@ubahTanggalLahir');
Route::post('/anak/{id}/tempatL','ApiController@ubahTempatLahir');
Route::post('/anak/{id}/kondisiL','ApiController@ubahKondisiLahir');
Route::post('/anak/{id}/pelayananL','ApiController@ubahPelayananLahir');
Route::post('/anak/{id}/ketL','ApiController@ubahKeteranganLahir');

// KematianAnak
Route::post('/anak/{id}/tanggalKematian','ApiController@ubahTanggalKematian');
Route::post('/anak/{id}/tempatM','ApiController@ubahTempatKematian');
Route::post('/anak/{id}/usiaM','ApiController@ubahUsiaKematian');
Route::post('/anak/{id}/penyebabM','ApiController@ubahPenyebabKematian');
Route::post('/anak/{id}/ketM','ApiController@ubahKeteranganKematian');

/*
*
* Imunisasi
*/

Route::post('/imunisasi/{id}/namaImunisasi','ApiController@ubahNamaImunisasi');
Route::post('/imunisasi/{id}/keteranganImunisasi','ApiController@ubahKeteranganImunisasi');
Route::post('/anak/{id}/tanggalImunisasi','ApiController@ubahTanggalImunisasi');

