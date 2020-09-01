<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ibu;
use App\Anak;
use App\KunjunganKb;
use App\KunjunganAnak;
use App\Prasekolah;
use App\KondisiLahir;
use App\KematianAnak;
use App\Imunisasi;

class ApiController extends Controller
{
    // Ibu
    /*
    *
    * KunjunganIbu-> Ibu
    */
    public function ubahUsia(Request $request,$id){
        $ibu = Ibu::find($id);
        // $ibu->kunjunganibu()->update($request->pk,['tgl_kunjungan' => $request->value]);
        $ibu->kunjunganibu()->where('id',$request->pk)->update(['usia_hamil' => $request->value]);
        // return $request;
    }
    public function ubahTanggal(Request $request,$id){
        $ibu = Ibu::find($id);
        // $ibu->kunjunganibu()->update($request->pk,['tgl_kunjungan' => $request->value]);
        $ibu->kunjunganibu()->where('id',$request->pk)->update(['tgl_kunjungan' => $request->value]);
        // return $request;
    }
    public function ubahKeterangan(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->kunjunganibu()->where('id',$request->pk)->update(['ket' => $request->value]);
    }

    /*
    *
    * IbuMelahirkan-> Ibu
    */
     public function ubahTanggalP(Request $request,$id){
        $ibu = Ibu::find($id);
        // $ibu->kunjunganibu()->update($request->pk,['tgl_kunjungan' => $request->value]);
        $ibu->persalinan()->where('id',$request->pk)->update(['tgl_persalinan' => $request->value]);
        // return $request;
    }
     public function ubahPenolong(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->persalinan()->where('id',$request->pk)->update(['tng_penolong' => $request->value]);
        // return $request;
    }
     public function ubahKelahiran(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->persalinan()->where('id',$request->pk)->update(['jenis_kelahiran' => $request->value]);
        // return $request;
    }

    /*
    *
    * IbuMenyusui-> Ibu
    */
     public function ubahTanggalNifas(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->ibumenyusui()->where('id',$request->pk)->update(['tgl_nifas' => $request->value]);
        // return $request;
    }
     public function ubahKetNifas(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->ibumenyusui()->where('id',$request->pk)->update(['ket' => $request->value]);
        // return $request;
    }
     public function ubahPeriode(Request $request,$id){
        $ibu = Ibu::find($id);
        $ibu->ibumenyusui()->where('id',$request->pk)->update(['periode_nifas' => $request->value]);
        // return $request;
    }

    //Keluarga Berencana

    public function ubahTanggalKB(Request $request, $id){
        KunjunganKb::whereId($request->pk)->update(['tgl_kunjungan'=>$request->value]);
        
    }
    public function ubahKategoriKB(Request $request, $id){
        KunjunganKb::whereId($request->pk)->update(['kategori_peserta'=>$request->value]);
    }
    public function ubahJenisKB(Request $request, $id){
        KunjunganKb::whereId($request->pk)->update(['jenis_kb'=>$request->value]);
    }
    public function ubahKetKB(Request $request, $id){
        KunjunganKb::whereId($request->pk)->update(['ket'=>$request->value]);
    }
    
    //Anak 
    /*
    *
    * Kunungan-> Anak
    */
    public function ubahTanggalAnak(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['tgl_kunjungan'=>$request->value]);
        
    }
    public function ubahKdPelayanan(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['kd_pelayanan'=>$request->value]);
        
    }
    public function ubahTempatP(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['tempat'=>$request->value]);
        
    }
    public function ubahUmurAnak(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['umur'=>$request->value]);
        
    }
    public function ubahBBAnak(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['bb'=>$request->value]);
        
    }
    public function ubahKondisiAnak(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['kondisi_anak'=>$request->value]);
        
    }
    public function ubahKetAnak(Request $request, $id){
        KunjunganAnak::whereId($request->pk)->update(['ket'=>$request->value]);
        
    }

    /*
    *
    * KondisiLahir-> Anak(status:Anak Balita)
    */
    
    public function ubahTanggalPelayanan(Request $request, $id){
        Prasekolah::whereId($request->pk)->update(['tgl_pelayanan'=>$request->value]);
    }
    public function ubahTempatPrasekolah(Request $request, $id){
        Prasekolah::whereId($request->pk)->update(['tempat'=>$request->value]);
    }
    public function ubahGiziP(Request $request, $id){
        Prasekolah::whereId($request->pk)->update(['status_gizi'=>$request->value]);
    }
    public function ubahArvP(Request $request, $id){
        Prasekolah::whereId($request->pk)->update(['pemberian_arv'=>$request->value]);
    }

    /*
    *
    * KondisiLahir-> Anak(status:Bayi)
    */
    public function ubahTanggalLahir(Request $request, $id){
        KondisiLahir::whereId($request->pk)->update(['tgl_pelayanan'=>$request->value]);
    }
    public function ubahTempatLahir(Request $request, $id){
        KondisiLahir::whereId($request->pk)->update(['tempat'=>$request->value]);
    }
    public function ubahKondisiLahir(Request $request, $id){
        KondisiLahir::whereId($request->pk)->update(['kd_kondisi'=>$request->value]);
    }
    public function ubahPelayananLahir(Request $request, $id){
        KondisiLahir::whereId($request->pk)->update(['kd_pelayanan'=>$request->value]);
    }
    public function ubahKeteranganLahir(Request $request, $id){
        KondisiLahir::whereId($request->pk)->update(['ket'=>$request->value]);
    }
    
    
    /*
    *
    * KematianAnak-> Anak
    */
    
    public function ubahTanggalKematian(Request $request, $id){
        KematianAnak::whereId($request->pk)->update(['tgl_kematian'=>$request->value]);
    }
    public function ubahTempatKematian(Request $request, $id){
        KematianAnak::whereId($request->pk)->update(['tempat'=>$request->value]);
    }
    public function ubahUsiaKematian(Request $request, $id){
        KematianAnak::whereId($request->pk)->update(['usia_kematian'=>$request->value]);
    }
    public function ubahPenyebabKematian(Request $request, $id){
        KematianAnak::whereId($request->pk)->update(['penyebab_kematian'=>$request->value]);
    }
    public function ubahKeteranganKematian(Request $request, $id){
        KematianAnak::whereId($request->pk)->update(['ket'=>$request->value]);
    }

    // Imunisasi
    /*
    *
    * Imunisasi ->imunisai_anak-> Anak
    */

    public function ubahNamaImunisasi(Request $request, $id){
        Imunisasi::whereId($request->pk)->update(['nama_imunisasi'=>$request->value]);
    }
    public function ubahKeteranganImunisasi(Request $request, $id){
        Imunisasi::whereId($request->pk)->update(['ket'=>$request->value]);
    }
    public function ubahTanggalImunisasi(Request $request, $id){
        $anak = Anak::find($id);
        $anak->imunisasi()->updateExistingPivot($request->pk,['tgl_kunjungan'=>$request->value]);
    }


}
