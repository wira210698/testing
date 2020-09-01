<?php

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
Route::get('/decode',function(){
    $a = '$2y$10$ag9mcpJZNnOfBsChoxMQmOhXfN08C4B75lqlzA4JOo07bO/VdcLbC';
    $decrypted = Illuminate\Support\Facades\Crypt::decryptString($a);
    echo "hasil decripty".$decrypted;
});
Route::group(['middleware'=>'guest'],function(){
    Route::get('/', function () {
        $data = App\Dokumentasi::all();
        $image = App\Dokumentasi::where('kategori','=','doc')->orderBy('created_at','desc')->take(9)->get();
        return view('home.home',compact('data','image'));
    })->name('home');
    Route::get('/login', function(){
        return view('login');
    });
    Route::post('/post_login', 'AuthController@login');
    
});

Route::get('/detail/{id}',function($id){
    if($id =='D0004'||$id =='D0001'||$id =='D0002'||$id =='D0000'){
        $data = App\Dokumentasi::whereId($id)->first();
        return view('home.detail', compact('data'));
    }else {
        return redirect('/');
    }
});

Route::group(['middleware'=>['auth','checkRole:petugas']],function(){
    
    Route::resource('/kader','AuthController');
    Route::post('/kader/{id}/password','AuthController@updateUser');
    //dokumentasi
    Route::resource('/doc', 'DokumentasiController');
    Route::get('/doc/{id}/doc','DokumentasiController@ubah');
    Route::get('/laporan','LaporanController@index');
    Route::get('/grafik', function(){
        return view('grafik.index');
    });
    Route::get('/grafik_ibu','GrafikController@ibu');
    Route::get('/grafik_kb','GrafikController@kb');
    Route::get('/grafik_anak','GrafikController@anak');
    Route::get('/laporan_ibu','LaporanController@report');
    Route::get('/laporan_kb','LaporanController@report');
    Route::get('/laporan_anak','LaporanController@report');
    Route::get('/exportPDF','LaporanController@exportPDF');
    Route::get('/kader/edit/petugas','AuthController@editPetugas');
    Route::post('/update/petugas','AuthController@updatePetugas');
    
});

Route::group(['middleware'=>['auth','checkRole:petugas,kader']],function(){
    Route::get('/logout', 'AuthController@logout');
    //ibu
    Route::resource('/ibu','IbuController');
    Route::get('/ibu/laporan/create','IbuController@report');
    Route::post('/ibu/{ibu}/addKunjungan','IbuController@addKunjungan');
    Route::delete('/ibu/{ibu}/{id}','IbuController@deleteKunjungan');
    Route::post('/ibu/{ibu}/addPersalinan','IbuController@addPersalinan');
    Route::post('/ibu/{ibu}/{id}/persalinan','IbuController@deletePersalinan');
    Route::post('/ibu/{ibu}/addMenyusui','IbuController@addMenyusui');
    Route::post('/ibu/{ibu}/{id}/menyusui','IbuController@deleteMenyusui');
    
    
    //Keluarga Berencana
    Route::resource('/KB','KeluargaBerencanaController');
    Route::post('/KB/{kb}/addKunjungan','KeluargaBerencanaController@addKunjungan');
    Route::delete('/KB/{kb}/{id}','KeluargaBerencanaController@deleteKunjungan');
    
    // Anak
    Route::resource('/anak','AnakController');
    Route::post('/anak/{anak}/addKunjungan','AnakController@addKunjungan');
    Route::delete('/anak/{anak}/{id}','AnakController@deleteKunjungan');
    
    Route::post('/anak/{anak}/addPrasekolah','AnakController@addPrasekolah');
    Route::delete('/anak/{anak}/{id}/prasekolah','AnakController@deletePrasekolah');
    
    Route::post('/anak/{anak}/addKondisiLahir','AnakController@addKondisiLahir');
    Route::delete('/anak/{anak}/{id}/kondisiLahir','AnakController@deleteKondisiLahir');
    
    Route::post('/anak/{anak}/addKematian','AnakController@addKematianAnak');
    Route::delete('/anak/{anak}/{id}/kematian','AnakController@deleteKematianAnak');
    
    // Imunisasi
    Route::resource('/imunisasi','ImunisasiController');
    Route::post('/anak/{anak}/addImunisasi','AnakController@addImunisasi');
    Route::delete('/anak/{anak}/{id}/imunisasi','AnakController@deleteImunisasi');
});
