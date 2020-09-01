<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dusun;
use App\KematianAnak;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.laporan');
    }
    public function report(Request $request)
    {
        $keterangan_laporan="";
        $keterangan="";
        if ($request->bulan != "") {
                $ReqBulanIni = $request->bulan;
                $ReqTahunIni = $request->tahun;
                if ($ReqBulanIni ==1) {
                $keterangan = "Januari ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==2) {
                    $keterangan = "Februari ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==3) {
                    $keterangan = "Maret ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==4) {
                    $keterangan = "April ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==5) {
                    $keterangan = "Mei ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==6) {
                    $keterangan = "Juni ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==7) {
                    $keterangan = "Juli ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==8) {
                    $keterangan = "Agustus ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==9) {
                    $keterangan = "September ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==10) {
                    $keterangan = "Oktober ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==11) {
                    $keterangan = "November ".$ReqTahunIni;
                }elseif ($ReqBulanIni ==12) {
                    $keterangan = "Desember ".$ReqTahunIni;
                }
            }

            
        $dusun= Dusun::all();
        if ($request->jenis_laporan == "Ibu") {

            $bln_lalu_K;
            $bln_lalu_P;
            $bln_lalu_M;
            $jmlhKunjunganBlnini=0;
            $jmlhKunjunganBlnLalu=0;
            $jmlhPersalinanBlnini=0;
            $jmlhPersalinanBlnlalu=0;
            $jmlhMenyusuiBlnini=0;
            $jmlhMenyusuiBlnlalu=0;
            $keterangan_laporan = $request->all();
            if ($request->bulan == '01') {
                $bln_lalu_K = '0';
                $bln_lalu_P = '0';
                $bln_lalu_M = '0';
            }else{
                $bln_lalu_K = $request->bulan - 1;
                $bln_lalu_P = $request->bulan - 1;
                $bln_lalu_M = $request->bulan - 1;
            }
            /**
             * mengelola laporan Kunjungan Ibu
             * 
             */
            $kunjungan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->whereNull('tb_kunjungan_ibu.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$bln_lalu_K)->whereYear('tgl_kunjungan','=',$request->tahun)->whereNull('tb_kunjungan_ibu.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $bulanini =[];
            $bulanlalu =[];
            $laporanK =[];
           
            foreach ($kunjungan_bulan_ini as $bulan ) {
                array_push($bulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($kunjungan_bulan_lalu as $bulanL ) {
                array_push($bulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $kunjungan_ibu =array_merge($bulanini,$bulanlalu);
                
            foreach ($kunjungan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($bulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_ibu,"nama_dusun"));
                    $a = $kunjungan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanK,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanlalu,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK,'nama_dusun'))) {
                        array_push($laporanK, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }
             usort($laporanK,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKunjunganBlnini+=$jumlah['bulan_ini'];
                    $jmlhKunjunganBlnLalu+=$jumlah['bulan_lalu'];
                }
            }
            
            
            /**
             * mengelola laporan jumlah Persalinan Ibu
             * 
             */


            $persalinan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_persalinan','reg_ibu.id','=','tb_persalinan.ibu_id')->
            whereMonth('tgl_persalinan','=',$request->bulan)->whereYear('tgl_persalinan','=',$request->tahun)->whereNull('tb_persalinan.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_persalinan.jenis_kelahiran) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $persalinan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_persalinan','reg_ibu.id','=','tb_persalinan.ibu_id')->
            whereMonth('tgl_persalinan','=',$bln_lalu_P)->whereYear('tgl_persalinan','=',$request->tahun)->whereNull('tb_persalinan.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_persalinan.jenis_kelahiran) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $Pbulanini =[];
            $Pbulanlalu =[];
            $laporanP =[];
           
            foreach ($persalinan_bulan_ini as $bulan ) {
                array_push($Pbulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($persalinan_bulan_lalu as $bulanL ) {
                array_push($Pbulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $persalinan_ibu =array_merge($Pbulanini,$Pbulanlalu);
            foreach ($persalinan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($Pbulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($persalinan_ibu,"nama_dusun"));
                    $a = $persalinan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanP,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($Pbulanlalu,'nama_dusun')))){
                    array_push($laporanP, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($Pbulanini,'nama_dusun')))){
                    array_push($laporanP, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $Dsn) {
                    if (!in_array($Dsn->nama_dusun,array_column($laporanP,'nama_dusun'))) {
                        array_push($laporanP, [
                            'nama_dusun'=> $Dsn->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }
            usort($laporanP,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanP as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhPersalinanBlnini+=$jumlah['bulan_ini'];
                    $jmlhPersalinanBlnlalu+=$jumlah['bulan_lalu'];
                }
            }
            
            /**
             * mengelola laporan Kunjungan Ibu Menyusui
             * 
             */

            $menyusui_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_ibu_menyusui','reg_ibu.id','=','tb_ibu_menyusui.ibu_id')->
            whereMonth('tgl_nifas','=',$request->bulan)->whereYear('tgl_nifas','=',$request->tahun)->whereNull('tb_ibu_menyusui.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_ibu_menyusui.periode_nifas) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $menyusui_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_ibu_menyusui','reg_ibu.id','=','tb_ibu_menyusui.ibu_id')->
            whereMonth('tgl_nifas','=',$bln_lalu_M)->whereYear('tgl_nifas','=',$request->tahun)->whereNull('tb_ibu_menyusui.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_ibu_menyusui.periode_nifas) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $Mbulanini =[];
            $Mbulanlalu =[];
            $laporanM =[];
           
            foreach ($menyusui_bulan_ini as $bulan ) {
                array_push($Mbulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($menyusui_bulan_lalu as $bulanL ) {
                array_push($Mbulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $kunjungan_ibu =array_merge($Mbulanini,$Mbulanlalu);
                
            foreach ($kunjungan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($Mbulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_ibu,"nama_dusun"));
                    $a = $kunjungan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanM,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($Mbulanlalu,'nama_dusun')))){
                    array_push($laporanM, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($Mbulanini,'nama_dusun')))){
                    array_push($laporanM, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $dusun) {
                    if (!in_array($dusun->nama_dusun,array_column($laporanM,'nama_dusun'))) {
                        array_push($laporanM, [
                            'nama_dusun'=> $dusun->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }

            usort($laporanM,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanM as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhMenyusuiBlnini+=$jumlah['bulan_ini'];
                    $jmlhMenyusuiBlnlalu+=$jumlah['bulan_lalu'];
                }
            }
            return view('laporan.indexIbu', compact('laporanM','keterangan_laporan','jmlhMenyusuiBlnini','jmlhMenyusuiBlnlalu','laporanP','jmlhPersalinanBlnini','jmlhPersalinanBlnlalu','laporanK','jmlhKunjunganBlnini','jmlhKunjunganBlnLalu','keterangan'));
        }elseif ($request->jenis_laporan == "KB") {
         
            $jmlhKB_baru_mkjp=0;
            $jmlhKB_baru_nonmkjp=0;
            $jmlhKB_lama_mkjp=0;
            $jmlhKB_lama_nonmkjp=0;
            
            $keterangan_laporan = $request->all();
           
            /**
             * mengelola laporan Kunjungan Ibu
             * 
             */
            $kunjungankb_baru_mkjp = DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Baru')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_baru_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['Pil KB','Kondom','Obat Vag'])->where('kategori_peserta','Peserta Baru')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            

            $baru_mkjp =[];
            $baru_nonmkjp =[];
            $laporanK =[];
           
            foreach ($kunjungankb_baru_mkjp as $b_mkjp ) {
                array_push($baru_mkjp, [
                    'nama_dusun'=> $b_mkjp->nama_dusun,
                    'MKJP'=> $b_mkjp->jmlh,
                    'NON_MKJP'=> 0
                    ]);
                }
            foreach ($kunjungankb_baru_nonmkjp as $b_nonmkjp ) {
                array_push($baru_nonmkjp, [
                    'nama_dusun'=> $b_nonmkjp->nama_dusun,
                    'MKJP'=> 0,
                    'NON_MKJP'=> $b_nonmkjp->jmlh
                    ]);
                }
            $kunjungan_kb_baru =array_merge($baru_mkjp,$baru_nonmkjp);

            foreach ($kunjungan_kb_baru as $data) {
                if ((in_array($data['nama_dusun'],array_column($baru_nonmkjp,'nama_dusun')))&&($data['NON_MKJP']!=0)) {
                    $nonmkjp_b = array("NON_MKJP"=>$data['NON_MKJP']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_kb_baru,"nama_dusun"));
                    $a = $kunjungan_kb_baru[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK,$ubahBL);
                    
                }elseif(($data['MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($baru_nonmkjp,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }elseif(($data['NON_MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK,'nama_dusun'))) {
                        array_push($laporanK, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'MKJP'=> 0,
                            'NON_MKJP'=> 0
                        ]);
                    }
                }
             usort($laporanK,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKB_baru_mkjp+=$jumlah['MKJP'];
                    $jmlhKB_baru_nonmkjp+=$jumlah['NON_MKJP'];
                }
            }

            /**
             * mengelola laporan Kunjungan KB lama
             * 
             */

            $kunjungankb_lama_mkjp = DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Lama')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_lama_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['Pil KB','Kondom','Obat Vag'])->where('kategori_peserta','Peserta Lama')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            

            $lama_mkjp =[];
            $lama_nonmkjp =[];
            $laporanL =[];
           
            foreach ($kunjungankb_lama_mkjp as $b_mkjp ) {
                array_push($lama_mkjp, [
                    'nama_dusun'=> $b_mkjp->nama_dusun,
                    'MKJP'=> $b_mkjp->jmlh,
                    'NON_MKJP'=> 0
                    ]);
                }
            foreach ($kunjungankb_lama_nonmkjp as $b_nonmkjp ) {
                array_push($lama_nonmkjp, [
                    'nama_dusun'=> $b_nonmkjp->nama_dusun,
                    'MKJP'=> 0,
                    'NON_MKJP'=> $b_nonmkjp->jmlh
                    ]);
                }
            $kunjungan_kb_baru =array_merge($lama_mkjp,$lama_nonmkjp);

            foreach ($kunjungan_kb_baru as $data) {
                if ((in_array($data['nama_dusun'],array_column($lama_nonmkjp,'nama_dusun')))&&($data['NON_MKJP']!=0)) {
                    $nonmkjp_b = array("NON_MKJP"=>$data['NON_MKJP']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_kb_baru,"nama_dusun"));
                    $a = $kunjungan_kb_baru[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanL,$ubahBL);
                    
                }elseif(($data['MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($lama_nonmkjp,'nama_dusun')))){
                    array_push($laporanL, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }elseif(($data['NON_MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanL, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }
            }
             foreach ($dusun as $dusun) {
                    if (!in_array($dusun->nama_dusun,array_column($laporanL,'nama_dusun'))) {
                        array_push($laporanL, [
                            'nama_dusun'=> $dusun->nama_dusun,
                            'MKJP'=> 0,
                            'NON_MKJP'=> 0
                        ]);
                    }
                }
             usort($laporanL,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanL as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKB_lama_mkjp+=$jumlah['MKJP'];
                    $jmlhKB_lama_nonmkjp+=$jumlah['NON_MKJP'];
                }
            }
            return view('laporan.indexKB', compact('laporanK','keterangan_laporan','laporanL','jmlhKB_baru_mkjp','jmlhKB_baru_nonmkjp','jmlhKB_lama_mkjp','jmlhKB_lama_nonmkjp','keterangan'));
            

        }elseif ($request->jenis_laporan == "Anak") {
            $jmlh_K_anak_L=0;
            $jmlh_K_anak_P=0;
            $jmlh_P_anak_L=0;
            $jmlh_P_anak_P=0;
            $jmlh_I_anak_L=0;
            $jmlh_I_anak_P=0;
            $jmlh_K_bayi_L=0;
            $jmlh_K_bayi_P=0;
            $jmlh_L_bayi_L=0;
            $jmlh_L_bayi_P=0;
            $jmlh_I_bayi_L=0;
            $jmlh_I_bayi_P=0;
            $jmlh_Di_anak=0;
            $jmlh_Di_bayi=0;
            $jmlh_Pn_anak=0;
            $jmlh_Pn_bayi=0;
            $jmlh_Ma_anak=0;
            $jmlh_Ma_bayi=0;
            $jmlh_Ca_anak=0;
            $jmlh_Ca_bayi=0;
            $jmlh_Db_anak=0;
            $jmlh_Db_bayi=0;
            $jmlh_Af_anak=0;
            $jmlh_Af_bayi=0;
            $jmlh_Ln_anak=0;
            $jmlh_Ln_bayi=0;


            
            $keterangan_laporan = $request->all();
           
            /**
             * mengelola laporan Kunjungan Anak
             * 
             */
            $kunjungan_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $K_anak_L =[];
            $K_anak_P =[];
            $laporanK_anak =[];
           
            foreach ($kunjungan_anak_L as $K_anakL ) {
                array_push($K_anak_L, [
                    'nama_dusun'=> $K_anakL->nama_dusun,
                    'L'=> $K_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kunjungan_anak_P as $K_anakP ) {
                array_push($K_anak_P, [
                    'nama_dusun'=> $K_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_anakP->jmlh
                    ]);
                }
            $kunjungan_anak =array_merge($K_anak_L,$K_anak_P);

            foreach ($kunjungan_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($K_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_anak,"nama_dusun"));
                    $a = $kunjungan_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($K_anak_P,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK_anak,'nama_dusun'))) {
                        array_push($laporanK_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanK_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_K_anak_L+=$jumlah['L'];
                    $jmlh_K_anak_P+=$jumlah['P'];
                }
            }

             /**
             * mengelola laporan Prasekolah Anak
             * 
             */
            $prasekolah_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_pelayanan_prasekolah','reg_anak.id','=','tb_pelayanan_prasekolah.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('tb_pelayanan_prasekolah.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_pelayanan_prasekolah.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $prasekolah_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_pelayanan_prasekolah','reg_anak.id','=','tb_pelayanan_prasekolah.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('tb_pelayanan_prasekolah.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_pelayanan_prasekolah.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $P_anak_L =[];
            $P_anak_P =[];
            $laporanP_anak =[];
           
            foreach ($prasekolah_anak_L as $K_anakL ) {
                array_push($P_anak_L, [
                    'nama_dusun'=> $K_anakL->nama_dusun,
                    'L'=> $K_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($prasekolah_anak_P as $K_anakP ) {
                array_push($P_anak_P, [
                    'nama_dusun'=> $K_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_anakP->jmlh
                    ]);
                }
            $prasekolah_anak =array_merge($P_anak_L,$P_anak_P);

            foreach ($prasekolah_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($P_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($prasekolah_anak,"nama_dusun"));
                    $a = $prasekolah_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanP_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($P_anak_P,'nama_dusun')))){
                    array_push($laporanP_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanP_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanP_anak,'nama_dusun'))) {
                        array_push($laporanP_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanP_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanP_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_P_anak_L+=$jumlah['L'];
                    $jmlh_P_anak_P+=$jumlah['P'];
                }
            }
            /**
             * mengelola laporan imunisasi Anak
             * 
             */
            $imunisasi_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $imunisasi_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $I_anak_L =[];
            $I_anak_P =[];
            $laporanI_anak =[];
           
            foreach ($imunisasi_anak_L as $I_anakL ) {
                array_push($I_anak_L, [
                    'nama_dusun'=> $I_anakL->nama_dusun,
                    'L'=> $I_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($imunisasi_anak_P as $I_anakP ) {
                array_push($I_anak_P, [
                    'nama_dusun'=> $I_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $I_anakP->jmlh
                    ]);
                }
            $imunisasi_anak =array_merge($I_anak_L,$I_anak_P);

            foreach ($imunisasi_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($I_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($imunisasi_anak,"nama_dusun"));
                    $a = $imunisasi_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanI_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($I_anak_P,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanI_anak,'nama_dusun'))) {
                        array_push($laporanI_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanI_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanI_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_I_anak_L+=$jumlah['L'];
                    $jmlh_I_anak_P+=$jumlah['P'];
                }
            }


            /**
             * mengelola laporan Kunjungan Bayi
             * 
             */
            $kunjungan_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $K_bayi_L =[];
            $K_bayi_P =[];
            $laporanK_bayi =[];
           
            foreach ($kunjungan_bayi_L as $K_bayiL ) {
                array_push($K_bayi_L, [
                    'nama_dusun'=> $K_bayiL->nama_dusun,
                    'L'=> $K_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kunjungan_bayi_P as $K_bayiP ) {
                array_push($K_bayi_P, [
                    'nama_dusun'=> $K_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_bayiP->jmlh
                    ]);
                }
            $kunjungan_bayi =array_merge($K_bayi_L,$K_bayi_P);

            foreach ($kunjungan_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($K_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_bayi,"nama_dusun"));
                    $a = $kunjungan_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($K_bayi_P,'nama_dusun')))){
                    array_push($laporanK_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK_bayi,'nama_dusun'))) {
                        array_push($laporanK_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanK_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_K_bayi_L+=$jumlah['L'];
                    $jmlh_K_bayi_P+=$jumlah['P'];
                }
            }

            /**
             * mengelola laporan Kondisi Lahir Bayi
             * 
             */
            $kondisi_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kondisi_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $L_bayi_L =[];
            $L_bayi_P =[];
            $laporanL_bayi =[];
           
            foreach ($kondisi_bayi_L as $K_bayiL ) {
                array_push($L_bayi_L, [
                    'nama_dusun'=> $K_bayiL->nama_dusun,
                    'L'=> $K_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kondisi_bayi_P as $K_bayiP ) {
                array_push($L_bayi_P, [
                    'nama_dusun'=> $K_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_bayiP->jmlh
                    ]);
                }
            $kondisi_bayi =array_merge($L_bayi_L,$L_bayi_P);

            foreach ($kondisi_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kondisi_bayi,"nama_dusun"));
                    $a = $kondisi_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanL_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanL_bayi,'nama_dusun'))) {
                        array_push($laporanL_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanL_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanL_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_L_bayi_L+=$jumlah['L'];
                    $jmlh_L_bayi_P+=$jumlah['P'];
                }
            }

            /**
             * mengelola laporan imunisasi Bayi
             * 
             */
            $imunisasi_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $imunisasi_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $I_bayi_L =[];
            $I_bayi_P =[];
            $laporanI_bayi =[];
           
            foreach ($imunisasi_bayi_L as $I_bayiL ) {
                array_push($I_bayi_L, [
                    'nama_dusun'=> $I_bayiL->nama_dusun,
                    'L'=> $I_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($imunisasi_bayi_P as $i_bayiP ) {
                array_push($I_bayi_P, [
                    'nama_dusun'=> $i_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $i_bayiP->jmlh
                    ]);
                }
            $imunisasi_bayi =array_merge($I_bayi_L,$I_bayi_P);

            foreach ($imunisasi_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($I_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($imunisasi_bayi,"nama_dusun"));
                    $a = $imunisasi_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanI_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($I_bayi_P,'nama_dusun')))){
                    array_push($laporanI_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanI_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanI_bayi,'nama_dusun'))) {
                        array_push($laporanI_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanI_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanI_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_I_bayi_L+=$jumlah['L'];
                    $jmlh_I_bayi_P+=$jumlah['P'];
                }
            }



            /**
             * mengelola laporan Kondisi Lahir Bayi
             * 
             */
            $kondisi_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kondisi_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $L_bayi_L =[];
            $L_bayi_P =[];
            $laporanL_bayi =[];
           
            foreach ($kondisi_bayi_L as $K_bayiL ) {
                array_push($L_bayi_L, [
                    'nama_dusun'=> $K_bayiL->nama_dusun,
                    'L'=> $K_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kondisi_bayi_P as $K_bayiP ) {
                array_push($L_bayi_P, [
                    'nama_dusun'=> $K_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_bayiP->jmlh
                    ]);
                }
            $kondisi_bayi =array_merge($L_bayi_L,$L_bayi_P);

            foreach ($kondisi_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kondisi_bayi,"nama_dusun"));
                    $a = $kondisi_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanL_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanL_bayi,'nama_dusun'))) {
                        array_push($laporanL_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanL_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanL_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_L_bayi_L+=$jumlah['L'];
                    $jmlh_L_bayi_P+=$jumlah['P'];
                }
            }

            /**
             * mengelola laporan diare meninggal
             * 
             */

            $diare_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','diare']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $diare_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','diare']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Di_anak =[];
            $Di_bayi =[];
            $laporanDi_anak =[];
           
            foreach ($diare_anak as $Di_ank ) {
                array_push($Di_anak, [
                    'nama_dusun'=> $Di_ank->nama_dusun,
                    'anak'=> $Di_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($diare_bayi as $Di_by ) {
                array_push($Di_bayi, [
                    'nama_dusun'=> $Di_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Di_by->jmlh
                    ]);
                }
            $diare_bayi =array_merge($Di_anak,$Di_bayi);

            foreach ($diare_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Di_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($diare_bayi,"nama_dusun"));
                    $a = $diare_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanDi_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Di_bayi,'nama_dusun')))){
                    array_push($laporanDi_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanDi_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanDi_anak,'nama_dusun'))) {
                        array_push($laporanDi_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanDi_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanDi_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Di_anak+=$jumlah['anak'];
                    $jmlh_Di_bayi+=$jumlah['bayi'];
                }
            }
            
            /**
             * mengelola laporan pneumonia meninggal
             * 
             */

            $pneumonia_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','pneumonia']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $pneumonia_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','pneumonia']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Pn_anak =[];
            $Pn_bayi =[];
            $laporanPn_anak =[];
           
            foreach ($pneumonia_anak as $Pn_ank ) {
                array_push($Pn_anak, [
                    'nama_dusun'=> $Pn_ank->nama_dusun,
                    'anak'=> $Pn_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($pneumonia_bayi as $Pn_by ) {
                array_push($Pn_bayi, [
                    'nama_dusun'=> $Pn_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Pn_by->jmlh
                    ]);
                }
            $pneumonia_bayi =array_merge($Pn_anak,$Pn_bayi);

            foreach ($pneumonia_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Pn_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($pneumonia_bayi,"nama_dusun"));
                    $a = $pneumonia_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanPn_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Pn_bayi,'nama_dusun')))){
                    array_push($laporanPn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanPn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanPn_anak,'nama_dusun'))) {
                        array_push($laporanPn_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanPn_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanPn_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Pn_anak+=$jumlah['anak'];
                    $jmlh_Pn_bayi+=$jumlah['bayi'];
                }
            }

            /**
             * mengelola laporan malaria meninggal
             * 
             */

            $malaria_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','malaria']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $malaria_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','malaria']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ma_anak =[];
            $Ma_bayi =[];
            $laporanMa_anak =[];
           
            foreach ($malaria_anak as $Ma_ank ) {
                array_push($Ma_anak, [
                    'nama_dusun'=> $Ma_ank->nama_dusun,
                    'anak'=> $Ma_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($malaria_bayi as $Ma_by ) {
                array_push($Ma_bayi, [
                    'nama_dusun'=> $Ma_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ma_by->jmlh
                    ]);
                }
            $malaria_bayi =array_merge($Ma_anak,$Ma_bayi);

            foreach ($malaria_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ma_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($malaria_bayi,"nama_dusun"));
                    $a = $malaria_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanMa_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ma_bayi,'nama_dusun')))){
                    array_push($laporanMa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanMa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanMa_anak,'nama_dusun'))) {
                        array_push($laporanMa_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanMa_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanMa_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ma_anak+=$jumlah['anak'];
                    $jmlh_Ma_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan campak meninggal
             * 
             */

            $campak_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','campak']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $campak_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','campak']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ca_anak =[];
            $Ca_bayi =[];
            $laporanCa_anak =[];
           
            foreach ($campak_anak as $Ca_ank ) {
                array_push($Ca_anak, [
                    'nama_dusun'=> $Ca_ank->nama_dusun,
                    'anak'=> $Ca_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($campak_bayi as $Ca_by ) {
                array_push($Ca_bayi, [
                    'nama_dusun'=> $Ca_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ca_by->jmlh
                    ]);
                }
            $campak_bayi =array_merge($Ca_anak,$Ca_bayi);

            foreach ($campak_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ca_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($campak_bayi,"nama_dusun"));
                    $a = $campak_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanCa_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ca_bayi,'nama_dusun')))){
                    array_push($laporanCa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanCa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanCa_anak,'nama_dusun'))) {
                        array_push($laporanCa_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanCa_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanCa_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ca_anak+=$jumlah['anak'];
                    $jmlh_Ca_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan DBD meninggal
             * 
             */

            $DBD_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','DBD']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $DBD_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','DBD']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Db_anak =[];
            $Db_bayi =[];
            $laporanDb_anak =[];
           
            foreach ($DBD_anak as $Db_ank ) {
                array_push($Db_anak, [
                    'nama_dusun'=> $Db_ank->nama_dusun,
                    'anak'=> $Db_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($DBD_bayi as $Db_by ) {
                array_push($Db_bayi, [
                    'nama_dusun'=> $Db_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Db_by->jmlh
                    ]);
                }
            $DBD_bayi =array_merge($Db_anak,$Db_bayi);

            foreach ($DBD_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Db_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($DBD_bayi,"nama_dusun"));
                    $a = $DBD_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanDb_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Db_bayi,'nama_dusun')))){
                    array_push($laporanDb_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanDb_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanDb_anak,'nama_dusun'))) {
                        array_push($laporanDb_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanDb_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanDb_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Db_anak+=$jumlah['anak'];
                    $jmlh_Db_bayi+=$jumlah['bayi'];
                }
            }

            /**
             * mengelola laporan difteri meninggal
             * 
             */

            $difteri_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','difteri']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $difteri_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','difteri']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Af_anak =[];
            $Af_bayi =[];
            $laporanAf_anak =[];
           
            foreach ($difteri_anak as $Af_ank ) {
                array_push($Af_anak, [
                    'nama_dusun'=> $Af_ank->nama_dusun,
                    'anak'=> $Af_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($difteri_bayi as $Af_by ) {
                array_push($Af_bayi, [
                    'nama_dusun'=> $Af_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Af_by->jmlh
                    ]);
                }
            $difteri_bayi =array_merge($Af_anak,$Af_bayi);

            foreach ($difteri_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Af_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($difteri_bayi,"nama_dusun"));
                    $a = $difteri_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanAf_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Af_bayi,'nama_dusun')))){
                    array_push($laporanAf_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanAf_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanAf_anak,'nama_dusun'))) {
                        array_push($laporanAf_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanAf_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanAf_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Af_anak+=$jumlah['anak'];
                    $jmlh_Af_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan lain-lain meninggal
             * 
             */

            $lain_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','lain-lain']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $lain_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','lain-lain']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ln_anak =[];
            $Ln_bayi =[];
            $laporanLn_anak =[];
           
            foreach ($lain_anak as $Ln_ank ) {
                array_push($Ln_anak, [
                    'nama_dusun'=> $Ln_ank->nama_dusun,
                    'anak'=> $Ln_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($lain_bayi as $Ln_by ) {
                array_push($Ln_bayi, [
                    'nama_dusun'=> $Ln_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ln_by->jmlh
                    ]);
                }
            $lain_bayi =array_merge($Ln_anak,$Ln_bayi);

            foreach ($lain_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ln_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($lain_bayi,"nama_dusun"));
                    $a = $lain_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanLn_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ln_bayi,'nama_dusun')))){
                    array_push($laporanLn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanLn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanLn_anak,'nama_dusun'))) {
                        array_push($laporanLn_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanLn_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanLn_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ln_anak+=$jumlah['anak'];
                    $jmlh_Ln_bayi+=$jumlah['bayi'];
                }
            }

            // dd($laporanLn_anak, $jmlh_Ln_anak,$jmlh_Ln_bayi);
            return view('laporan.indexAnak', compact('laporanK_anak','laporanP_anak','laporanI_anak','laporanK_bayi','laporanL_bayi',
            'laporanI_bayi','laporanDi_anak','laporanPn_anak','laporanMa_anak','laporanCa_anak','laporanDb_anak',
            'laporanAf_anak','laporanLn_anak','jmlh_Di_anak','jmlh_Di_bayi','jmlh_Pn_anak','jmlh_Pn_bayi','jmlh_Ma_anak','jmlh_Ma_bayi',
            'jmlh_Ca_anak','jmlh_Ca_bayi','jmlh_Db_anak','jmlh_Db_bayi','jmlh_Af_anak','jmlh_Af_bayi','jmlh_Ln_anak','jmlh_Ln_bayi',
            'keterangan_laporan','jmlh_K_anak_L','jmlh_K_anak_P','jmlh_P_anak_L','jmlh_P_anak_P','jmlh_I_anak_L','jmlh_I_anak_P',
            'jmlh_K_bayi_L','jmlh_K_bayi_P','jmlh_L_bayi_L','jmlh_L_bayi_P','jmlh_I_bayi_L','jmlh_I_bayi_P','keterangan'));

            
        }elseif(request()->segment(count(request()->segments())) == 'laporan_ibu'){
            return view('laporan.indexIbu', compact('keterangan_laporan','keterangan'));
            
        }elseif(request()->segment(count(request()->segments())) == 'laporan_anak'){
            return view('laporan.indexAnak', compact('keterangan_laporan','keterangan'));
            
        }elseif(request()->segment(count(request()->segments())) == 'laporan_kb'){
            return view('laporan.indexKB', compact('keterangan_laporan','keterangan'));
            
        }
    }

    public function exportPDF(Request $request)
    {
        $dusun= Dusun::all();
        $tanggal= date("d-m-Y");
        $keterangan_laporan;
        if ($request->bulan ==1) {
            $keterangan_laporan = "Januari ".$request->tahun;
        }elseif ($request->bulan ==2) {
            $keterangan_laporan = "Februari ".$request->tahun;
        }elseif ($request->bulan ==3) {
            $keterangan_laporan = "Maret ".$request->tahun;
        }elseif ($request->bulan ==4) {
            $keterangan_laporan = "April ".$request->tahun;
        }elseif ($request->bulan ==5) {
            $keterangan_laporan = "Mei ".$request->tahun;
        }elseif ($request->bulan ==6) {
            $keterangan_laporan = "Juni ".$request->tahun;
        }elseif ($request->bulan ==7) {
            $keterangan_laporan = "Juli ".$request->tahun;
        }elseif ($request->bulan ==8) {
            $keterangan_laporan = "Agustus ".$request->tahun;
        }elseif ($request->bulan ==9) {
            $keterangan_laporan = "September ".$request->tahun;
        }elseif ($request->bulan ==10) {
            $keterangan_laporan = "Oktober ".$request->tahun;
        }elseif ($request->bulan ==11) {
            $keterangan_laporan = "November ".$request->tahun;
        }elseif ($request->bulan ==12) {
            $keterangan_laporan = "Desember ".$request->tahun;
        }


        if ($request->jenis_laporan == "Ibu") {

            $bln_lalu_K;
            $bln_lalu_P;
            $bln_lalu_M;
            $jmlhKunjunganBlnini=0;
            $jmlhKunjunganBlnLalu=0;
            $jmlhPersalinanBlnini=0;
            $jmlhPersalinanBlnlalu=0;
            $jmlhMenyusuiBlnini=0;
            $jmlhMenyusuiBlnlalu=0;
            if ($request->bulan == '01') {
                $bln_lalu_K = '0';
                $bln_lalu_P = '0';
                $bln_lalu_M = '0';
            }else{
                $bln_lalu_K = $request->bulan - 1;
                $bln_lalu_P = $request->bulan - 1;
                $bln_lalu_M = $request->bulan - 1;
            }
            /**
             * mengelola laporan Kunjungan Ibu
             * 
             */
            $kunjungan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereNull('tb_kunjungan_ibu.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$bln_lalu_K)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereNull('tb_kunjungan_ibu.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $bulanini =[];
            $bulanlalu =[];
            $laporanK =[];
           
            foreach ($kunjungan_bulan_ini as $bulan ) {
                array_push($bulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($kunjungan_bulan_lalu as $bulanL ) {
                array_push($bulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $kunjungan_ibu =array_merge($bulanini,$bulanlalu);
                
            foreach ($kunjungan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($bulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_ibu,"nama_dusun"));
                    $a = $kunjungan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanK,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanlalu,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK,'nama_dusun'))) {
                        array_push($laporanK, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }
             usort($laporanK,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKunjunganBlnini+=$jumlah['bulan_ini'];
                    $jmlhKunjunganBlnLalu+=$jumlah['bulan_lalu'];
                }
            }
            
            
            /**
             * mengelola laporan jumlah Persalinan Ibu
             * 
             */


            $persalinan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_persalinan','reg_ibu.id','=','tb_persalinan.ibu_id')->
            whereMonth('tgl_persalinan','=',$request->bulan)->whereYear('tgl_persalinan','=',$request->tahun)->
            whereNull('tb_persalinan.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_persalinan.jenis_kelahiran) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $persalinan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_persalinan','reg_ibu.id','=','tb_persalinan.ibu_id')->
            whereMonth('tgl_persalinan','=',$bln_lalu_P)->whereYear('tgl_persalinan','=',$request->tahun)->
            whereNull('tb_persalinan.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_persalinan.jenis_kelahiran) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $Pbulanini =[];
            $Pbulanlalu =[];
            $laporanP =[];
           
            foreach ($persalinan_bulan_ini as $bulan ) {
                array_push($Pbulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($persalinan_bulan_lalu as $bulanL ) {
                array_push($Pbulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $persalinan_ibu =array_merge($Pbulanini,$Pbulanlalu);
            foreach ($persalinan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($Pbulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($persalinan_ibu,"nama_dusun"));
                    $a = $persalinan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanP,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($Pbulanlalu,'nama_dusun')))){
                    array_push($laporanP, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($Pbulanini,'nama_dusun')))){
                    array_push($laporanP, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $Dsn) {
                    if (!in_array($Dsn->nama_dusun,array_column($laporanP,'nama_dusun'))) {
                        array_push($laporanP, [
                            'nama_dusun'=> $Dsn->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }
            usort($laporanP,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanP as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhPersalinanBlnini+=$jumlah['bulan_ini'];
                    $jmlhPersalinanBlnlalu+=$jumlah['bulan_lalu'];
                }
            }
            
            /**
             * mengelola laporan Kunjungan Ibu Menyusui
             * 
             */

            $menyusui_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_ibu_menyusui','reg_ibu.id','=','tb_ibu_menyusui.ibu_id')->
            whereMonth('tgl_nifas','=',$request->bulan)->whereYear('tgl_nifas','=',$request->tahun)->
            whereNull('tb_ibu_menyusui.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_ibu_menyusui.periode_nifas) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $menyusui_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_ibu_menyusui','reg_ibu.id','=','tb_ibu_menyusui.ibu_id')->
            whereMonth('tgl_nifas','=',$bln_lalu_M)->whereYear('tgl_nifas','=',$request->tahun)->
            whereNull('tb_ibu_menyusui.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_ibu_menyusui.periode_nifas) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            $Mbulanini =[];
            $Mbulanlalu =[];
            $laporanM =[];
           
            foreach ($menyusui_bulan_ini as $bulan ) {
                array_push($Mbulanini, [
                    'nama_dusun'=> $bulan->nama_dusun,
                    'bulan_ini'=> $bulan->jmlh,
                    'bulan_lalu'=> 0
                    ]);
                }
            foreach ($menyusui_bulan_lalu as $bulanL ) {
                array_push($Mbulanlalu, [
                    'nama_dusun'=> $bulanL->nama_dusun,
                    'bulan_ini'=> 0,
                    'bulan_lalu'=> $bulanL->jmlh
                    ]);
                }
            $kunjungan_ibu =array_merge($Mbulanini,$Mbulanlalu);
                
            foreach ($kunjungan_ibu as $data) {
                if ((in_array($data['nama_dusun'],array_column($Mbulanlalu,'nama_dusun')))&&($data['bulan_lalu']!=0)) {
                    $bulan_lalu = array("bulan_lalu"=>$data['bulan_lalu']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_ibu,"nama_dusun"));
                    $a = $kunjungan_ibu[$key];
                    $ubahBL = array_replace($a,$bulan_lalu);
                    array_push($laporanM,$ubahBL);
                    
                }elseif(($data['bulan_ini']!=0)&&(!in_array($data['nama_dusun'],array_column($Mbulanlalu,'nama_dusun')))){
                    array_push($laporanM, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }elseif(($data['bulan_lalu']!=0)&&(!in_array($data['nama_dusun'],array_column($Mbulanini,'nama_dusun')))){
                    array_push($laporanM, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'bulan_ini'=>$data['bulan_ini'],
                        'bulan_lalu'=> $data['bulan_lalu']
                    ]);
                }
            }
                foreach ($dusun as $dusun) {
                    if (!in_array($dusun->nama_dusun,array_column($laporanM,'nama_dusun'))) {
                        array_push($laporanM, [
                            'nama_dusun'=> $dusun->nama_dusun,
                            'bulan_ini'=> 0,
                            'bulan_lalu'=> 0
                        ]);
                    }
                }

            usort($laporanM,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanM as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhMenyusuiBlnini+=$jumlah['bulan_ini'];
                    $jmlhMenyusuiBlnlalu+=$jumlah['bulan_lalu'];
                }
            }

            $pdf = PDF::loadView('laporan.laporanIbu',compact('laporanM','keterangan_laporan','jmlhMenyusuiBlnini','jmlhMenyusuiBlnlalu','laporanP','jmlhPersalinanBlnini','jmlhPersalinanBlnlalu','laporanK','jmlhKunjunganBlnini','jmlhKunjunganBlnLalu'));
            $pdf->setPaper('legal','landscape');

            return $pdf->stream('laporan_Ibu_'.$tanggal.'.pdf');
            // return view('laporan.laporanIbu', compact('laporanM','keterangan_laporan','jmlhMenyusuiBlnini','jmlhMenyusuiBlnlalu','laporanP','jmlhPersalinanBlnini','jmlhPersalinanBlnlalu','laporanK','jmlhKunjunganBlnini','jmlhKunjunganBlnLalu'));

        }elseif ($request->jenis_laporan == "KB") {
         
            $jmlhKB_baru_mkjp=0;
            $jmlhKB_baru_nonmkjp=0;
            $jmlhKB_lama_mkjp=0;
            $jmlhKB_lama_nonmkjp=0;
           
            /**
             * mengelola laporan Kunjungan Ibu
             * 
             */
            $kunjungankb_baru_mkjp = DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Baru')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_baru_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['Pil KB','Kondom','Obat Vag'])->where('kategori_peserta','Peserta Baru')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            

            $baru_mkjp =[];
            $baru_nonmkjp =[];
            $laporanK =[];
           
            foreach ($kunjungankb_baru_mkjp as $b_mkjp ) {
                array_push($baru_mkjp, [
                    'nama_dusun'=> $b_mkjp->nama_dusun,
                    'MKJP'=> $b_mkjp->jmlh,
                    'NON_MKJP'=> 0
                    ]);
                }
            foreach ($kunjungankb_baru_nonmkjp as $b_nonmkjp ) {
                array_push($baru_nonmkjp, [
                    'nama_dusun'=> $b_nonmkjp->nama_dusun,
                    'MKJP'=> 0,
                    'NON_MKJP'=> $b_nonmkjp->jmlh
                    ]);
                }
            $kunjungan_kb_baru =array_merge($baru_mkjp,$baru_nonmkjp);

            foreach ($kunjungan_kb_baru as $data) {
                if ((in_array($data['nama_dusun'],array_column($baru_nonmkjp,'nama_dusun')))&&($data['NON_MKJP']!=0)) {
                    $nonmkjp_b = array("NON_MKJP"=>$data['NON_MKJP']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_kb_baru,"nama_dusun"));
                    $a = $kunjungan_kb_baru[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK,$ubahBL);
                    
                }elseif(($data['MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($baru_nonmkjp,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }elseif(($data['NON_MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK,'nama_dusun'))) {
                        array_push($laporanK, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'MKJP'=> 0,
                            'NON_MKJP'=> 0
                        ]);
                    }
                }
             usort($laporanK,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKB_baru_mkjp+=$jumlah['MKJP'];
                    $jmlhKB_baru_nonmkjp+=$jumlah['NON_MKJP'];
                }
            }

            /**
             * mengelola laporan Kunjungan KB lama
             * 
             */

            $kunjungankb_lama_mkjp = DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Lama')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_lama_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            whereIn('jenis_kb',['Pil KB','Kondom','Obat Vag'])->where('kategori_peserta','Peserta Lama')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            

            $lama_mkjp =[];
            $lama_nonmkjp =[];
            $laporanL =[];
           
            foreach ($kunjungankb_lama_mkjp as $b_mkjp ) {
                array_push($lama_mkjp, [
                    'nama_dusun'=> $b_mkjp->nama_dusun,
                    'MKJP'=> $b_mkjp->jmlh,
                    'NON_MKJP'=> 0
                    ]);
                }
            foreach ($kunjungankb_lama_nonmkjp as $b_nonmkjp ) {
                array_push($lama_nonmkjp, [
                    'nama_dusun'=> $b_nonmkjp->nama_dusun,
                    'MKJP'=> 0,
                    'NON_MKJP'=> $b_nonmkjp->jmlh
                    ]);
                }
            $kunjungan_kb_baru =array_merge($lama_mkjp,$lama_nonmkjp);

            foreach ($kunjungan_kb_baru as $data) {
                if ((in_array($data['nama_dusun'],array_column($lama_nonmkjp,'nama_dusun')))&&($data['NON_MKJP']!=0)) {
                    $nonmkjp_b = array("NON_MKJP"=>$data['NON_MKJP']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_kb_baru,"nama_dusun"));
                    $a = $kunjungan_kb_baru[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanL,$ubahBL);
                    
                }elseif(($data['MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($lama_nonmkjp,'nama_dusun')))){
                    array_push($laporanL, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }elseif(($data['NON_MKJP']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanL, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'MKJP'=>$data['MKJP'],
                        'NON_MKJP'=> $data['NON_MKJP']
                    ]);
                }
            }
             foreach ($dusun as $dusun) {
                    if (!in_array($dusun->nama_dusun,array_column($laporanL,'nama_dusun'))) {
                        array_push($laporanL, [
                            'nama_dusun'=> $dusun->nama_dusun,
                            'MKJP'=> 0,
                            'NON_MKJP'=> 0
                        ]);
                    }
                }
             usort($laporanL,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanL as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhKB_lama_mkjp+=$jumlah['MKJP'];
                    $jmlhKB_lama_nonmkjp+=$jumlah['NON_MKJP'];
                }
            }

            $pdf = PDF::loadView('laporan.laporanKB',compact('laporanK','keterangan_laporan','laporanL','jmlhKB_baru_mkjp','jmlhKB_baru_nonmkjp','jmlhKB_lama_mkjp','jmlhKB_lama_nonmkjp'));
            $pdf->setPaper('legal','landscape');

            return $pdf->stream('laporan_KB_'.$tanggal.'.pdf');
            // return view('laporan.laporanKB', compact('laporanK','keterangan_laporan','laporanL','jmlhKB_baru_mkjp','jmlhKB_baru_nonmkjp','jmlhKB_lama_mkjp','jmlhKB_lama_nonmkjp'));
            

        }elseif ($request->jenis_laporan == "anak") {
           $jmlh_K_anak_L=0;
            $jmlh_K_anak_P=0;
            $jmlh_P_anak_L=0;
            $jmlh_P_anak_P=0;
            $jmlh_I_anak_L=0;
            $jmlh_I_anak_P=0;

            /**
             * mengelola laporan Kunjungan Anak
             * 
             */
            $kunjungan_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $K_anak_L =[];
            $K_anak_P =[];
            $laporanK_anak =[];
           
            foreach ($kunjungan_anak_L as $K_anakL ) {
                array_push($K_anak_L, [
                    'nama_dusun'=> $K_anakL->nama_dusun,
                    'L'=> $K_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kunjungan_anak_P as $K_anakP ) {
                array_push($K_anak_P, [
                    'nama_dusun'=> $K_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_anakP->jmlh
                    ]);
                }
            $kunjungan_anak =array_merge($K_anak_L,$K_anak_P);

            foreach ($kunjungan_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($K_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_anak,"nama_dusun"));
                    $a = $kunjungan_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($K_anak_P,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK_anak,'nama_dusun'))) {
                        array_push($laporanK_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanK_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_K_anak_L+=$jumlah['L'];
                    $jmlh_K_anak_P+=$jumlah['P'];
                }
            }

             /**
             * mengelola laporan Prasekolah Anak
             * 
             */
            $prasekolah_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_pelayanan_prasekolah','reg_anak.id','=','tb_pelayanan_prasekolah.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('tb_pelayanan_prasekolah.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_pelayanan_prasekolah.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $prasekolah_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_pelayanan_prasekolah','reg_anak.id','=','tb_pelayanan_prasekolah.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('tb_pelayanan_prasekolah.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_pelayanan_prasekolah.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $P_anak_L =[];
            $P_anak_P =[];
            $laporanP_anak =[];
           
            foreach ($prasekolah_anak_L as $K_anakL ) {
                array_push($P_anak_L, [
                    'nama_dusun'=> $K_anakL->nama_dusun,
                    'L'=> $K_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($prasekolah_anak_P as $K_anakP ) {
                array_push($P_anak_P, [
                    'nama_dusun'=> $K_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_anakP->jmlh
                    ]);
                }
            $prasekolah_anak =array_merge($P_anak_L,$P_anak_P);

            foreach ($prasekolah_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($P_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($prasekolah_anak,"nama_dusun"));
                    $a = $prasekolah_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanP_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($P_anak_P,'nama_dusun')))){
                    array_push($laporanP_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanP_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanP_anak,'nama_dusun'))) {
                        array_push($laporanP_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanP_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanP_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_P_anak_L+=$jumlah['L'];
                    $jmlh_P_anak_P+=$jumlah['P'];
                }
            }
            /**
             * mengelola laporan imunisasi Anak
             * 
             */
            $imunisasi_anak_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',1)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $imunisasi_anak_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->where('jk',0)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $I_anak_L =[];
            $I_anak_P =[];
            $laporanI_anak =[];
           
            foreach ($imunisasi_anak_L as $I_anakL ) {
                array_push($I_anak_L, [
                    'nama_dusun'=> $I_anakL->nama_dusun,
                    'L'=> $I_anakL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($imunisasi_anak_P as $I_anakP ) {
                array_push($I_anak_P, [
                    'nama_dusun'=> $I_anakP->nama_dusun,
                    'L'=> 0,
                    'P'=> $I_anakP->jmlh
                    ]);
                }
            $imunisasi_anak =array_merge($I_anak_L,$I_anak_P);

            foreach ($imunisasi_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($I_anak_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($imunisasi_anak,"nama_dusun"));
                    $a = $imunisasi_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanI_anak,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($I_anak_P,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanI_anak,'nama_dusun'))) {
                        array_push($laporanI_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanI_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanI_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_I_anak_L+=$jumlah['L'];
                    $jmlh_I_anak_P+=$jumlah['P'];
                }
            }

            $pdf = PDF::loadView('laporan.laporanAnak',compact('laporanK_anak','laporanP_anak','laporanI_anak','keterangan_laporan','jmlh_K_anak_L','jmlh_K_anak_P','jmlh_P_anak_L','jmlh_P_anak_P','jmlh_I_anak_L','jmlh_I_anak_P'));
            $pdf->setPaper('legal','landscape');

            return $pdf->stream('laporan_KB_'.$tanggal.'.pdf');   
        }elseif ($request->jenis_laporan == "bayi") {
            

            $jmlh_K_bayi_L=0;
            $jmlh_K_bayi_P=0;
            $jmlh_L_bayi_L=0;
            $jmlh_L_bayi_P=0;
            $jmlh_I_bayi_L=0;
            $jmlh_I_bayi_P=0;
            /**
             * mengelola laporan Kunjungan Bayi
             * 
             */
            $kunjungan_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $K_bayi_L =[];
            $K_bayi_P =[];
            $laporanK_bayi =[];
           
            foreach ($kunjungan_bayi_L as $K_bayiL ) {
                array_push($K_bayi_L, [
                    'nama_dusun'=> $K_bayiL->nama_dusun,
                    'L'=> $K_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kunjungan_bayi_P as $K_bayiP ) {
                array_push($K_bayi_P, [
                    'nama_dusun'=> $K_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_bayiP->jmlh
                    ]);
                }
            $kunjungan_bayi =array_merge($K_bayi_L,$K_bayi_P);

            foreach ($kunjungan_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($K_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_bayi,"nama_dusun"));
                    $a = $kunjungan_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($K_bayi_P,'nama_dusun')))){
                    array_push($laporanK_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK_bayi,'nama_dusun'))) {
                        array_push($laporanK_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanK_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_K_bayi_L+=$jumlah['L'];
                    $jmlh_K_bayi_P+=$jumlah['P'];
                }
            }

            /**
             * mengelola laporan Kondisi Lahir Bayi
             * 
             */
            $kondisi_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kondisi_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kondisi_lahir','reg_anak.id','=','tb_kondisi_lahir.anak_id')->
            whereMonth('tgl_pelayanan','=',$request->bulan)->whereYear('tgl_pelayanan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('tb_kondisi_lahir.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kondisi_lahir.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $L_bayi_L =[];
            $L_bayi_P =[];
            $laporanL_bayi =[];
           
            foreach ($kondisi_bayi_L as $K_bayiL ) {
                array_push($L_bayi_L, [
                    'nama_dusun'=> $K_bayiL->nama_dusun,
                    'L'=> $K_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($kondisi_bayi_P as $K_bayiP ) {
                array_push($L_bayi_P, [
                    'nama_dusun'=> $K_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $K_bayiP->jmlh
                    ]);
                }
            $kondisi_bayi =array_merge($L_bayi_L,$L_bayi_P);

            foreach ($kondisi_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($kondisi_bayi,"nama_dusun"));
                    $a = $kondisi_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanL_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($L_bayi_P,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanL_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanL_bayi,'nama_dusun'))) {
                        array_push($laporanL_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanL_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanL_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_L_bayi_L+=$jumlah['L'];
                    $jmlh_L_bayi_P+=$jumlah['P'];
                }
            }

            /**
             * mengelola laporan imunisasi Bayi
             * 
             */
            $imunisasi_bayi_L = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',1)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $imunisasi_bayi_P = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->where('jk',0)->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $I_bayi_L =[];
            $I_bayi_P =[];
            $laporanI_bayi =[];
           
            foreach ($imunisasi_bayi_L as $I_bayiL ) {
                array_push($I_bayi_L, [
                    'nama_dusun'=> $I_bayiL->nama_dusun,
                    'L'=> $I_bayiL->jmlh,
                    'P'=> 0
                    ]);
                }
            foreach ($imunisasi_bayi_P as $i_bayiP ) {
                array_push($I_bayi_P, [
                    'nama_dusun'=> $i_bayiP->nama_dusun,
                    'L'=> 0,
                    'P'=> $i_bayiP->jmlh
                    ]);
                }
            $imunisasi_bayi =array_merge($I_bayi_L,$I_bayi_P);

            foreach ($imunisasi_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($I_bayi_P,'nama_dusun')))&&($data['P']!=0)) {
                    $nonmkjp_b = array("P"=>$data['P']);
                    $key =array_search($data['nama_dusun'],array_column($imunisasi_bayi,"nama_dusun"));
                    $a = $imunisasi_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanI_bayi,$ubahBL);
                    
                }elseif(($data['L']!=0)&&(!in_array($data['nama_dusun'],array_column($I_bayi_P,'nama_dusun')))){
                    array_push($laporanI_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }elseif(($data['P']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanI_bayi, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'L'=>$data['L'],
                        'P'=> $data['P']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanI_bayi,'nama_dusun'))) {
                        array_push($laporanI_bayi, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'L'=> 0,
                            'P'=> 0
                        ]);
                    }
                }
             usort($laporanI_bayi,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanI_bayi as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_I_bayi_L+=$jumlah['L'];
                    $jmlh_I_bayi_P+=$jumlah['P'];
                }
            }
          

            $pdf = PDF::loadView('laporan.laporanBayi',compact('laporanK_bayi','laporanL_bayi','laporanI_bayi','keterangan_laporan','jmlh_K_bayi_L','jmlh_K_bayi_P','jmlh_L_bayi_L','jmlh_L_bayi_P','jmlh_I_bayi_L','jmlh_I_bayi_P'));
            $pdf->setPaper('legal','landscape');

            return $pdf->stream('laporan_KB_'.$tanggal.'.pdf'); 
        }elseif ($request->jenis_laporan == "anak_meninggal") {
            
            $jmlh_Di_anak=0;
            $jmlh_Di_bayi=0;
            $jmlh_Pn_anak=0;
            $jmlh_Pn_bayi=0;
            $jmlh_Ma_anak=0;
            $jmlh_Ma_bayi=0;
            $jmlh_Ca_anak=0;
            $jmlh_Ca_bayi=0;
            $jmlh_Db_anak=0;
            $jmlh_Db_bayi=0;
            $jmlh_Af_anak=0;
            $jmlh_Af_bayi=0;
            $jmlh_Ln_anak=0;
            $jmlh_Ln_bayi=0;
            
            /**
             * mengelola laporan diare meninggal
             * 
             */

            $diare_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','diare']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $diare_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','diare']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Di_anak =[];
            $Di_bayi =[];
            $laporanDi_anak =[];
           
            foreach ($diare_anak as $Di_ank ) {
                array_push($Di_anak, [
                    'nama_dusun'=> $Di_ank->nama_dusun,
                    'anak'=> $Di_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($diare_bayi as $Di_by ) {
                array_push($Di_bayi, [
                    'nama_dusun'=> $Di_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Di_by->jmlh
                    ]);
                }
            $diare_bayi =array_merge($Di_anak,$Di_bayi);

            foreach ($diare_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Di_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($diare_bayi,"nama_dusun"));
                    $a = $diare_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanDi_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Di_bayi,'nama_dusun')))){
                    array_push($laporanDi_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanDi_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanDi_anak,'nama_dusun'))) {
                        array_push($laporanDi_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanDi_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanDi_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Di_anak+=$jumlah['anak'];
                    $jmlh_Di_bayi+=$jumlah['bayi'];
                }
            }
            
            /**
             * mengelola laporan pneumonia meninggal
             * 
             */

            $pneumonia_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','pneumonia']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $pneumonia_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','pneumonia']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Pn_anak =[];
            $Pn_bayi =[];
            $laporanPn_anak =[];
           
            foreach ($pneumonia_anak as $Pn_ank ) {
                array_push($Pn_anak, [
                    'nama_dusun'=> $Pn_ank->nama_dusun,
                    'anak'=> $Pn_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($pneumonia_bayi as $Pn_by ) {
                array_push($Pn_bayi, [
                    'nama_dusun'=> $Pn_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Pn_by->jmlh
                    ]);
                }
            $pneumonia_bayi =array_merge($Pn_anak,$Pn_bayi);

            foreach ($pneumonia_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Pn_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($pneumonia_bayi,"nama_dusun"));
                    $a = $pneumonia_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanPn_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Pn_bayi,'nama_dusun')))){
                    array_push($laporanPn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanPn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanPn_anak,'nama_dusun'))) {
                        array_push($laporanPn_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanPn_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanPn_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Pn_anak+=$jumlah['anak'];
                    $jmlh_Pn_bayi+=$jumlah['bayi'];
                }
            }

            /**
             * mengelola laporan malaria meninggal
             * 
             */

            $malaria_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','malaria']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $malaria_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','malaria']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ma_anak =[];
            $Ma_bayi =[];
            $laporanMa_anak =[];
           
            foreach ($malaria_anak as $Ma_ank ) {
                array_push($Ma_anak, [
                    'nama_dusun'=> $Ma_ank->nama_dusun,
                    'anak'=> $Ma_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($malaria_bayi as $Ma_by ) {
                array_push($Ma_bayi, [
                    'nama_dusun'=> $Ma_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ma_by->jmlh
                    ]);
                }
            $malaria_bayi =array_merge($Ma_anak,$Ma_bayi);

            foreach ($malaria_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ma_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($malaria_bayi,"nama_dusun"));
                    $a = $malaria_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanMa_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ma_bayi,'nama_dusun')))){
                    array_push($laporanMa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanMa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanMa_anak,'nama_dusun'))) {
                        array_push($laporanMa_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanMa_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanMa_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ma_anak+=$jumlah['anak'];
                    $jmlh_Ma_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan campak meninggal
             * 
             */

            $campak_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','campak']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $campak_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','campak']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ca_anak =[];
            $Ca_bayi =[];
            $laporanCa_anak =[];
           
            foreach ($campak_anak as $Ca_ank ) {
                array_push($Ca_anak, [
                    'nama_dusun'=> $Ca_ank->nama_dusun,
                    'anak'=> $Ca_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($campak_bayi as $Ca_by ) {
                array_push($Ca_bayi, [
                    'nama_dusun'=> $Ca_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ca_by->jmlh
                    ]);
                }
            $campak_bayi =array_merge($Ca_anak,$Ca_bayi);

            foreach ($campak_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ca_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($campak_bayi,"nama_dusun"));
                    $a = $campak_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanCa_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ca_bayi,'nama_dusun')))){
                    array_push($laporanCa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanCa_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanCa_anak,'nama_dusun'))) {
                        array_push($laporanCa_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanCa_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanCa_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ca_anak+=$jumlah['anak'];
                    $jmlh_Ca_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan DBD meninggal
             * 
             */

            $DBD_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','DBD']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $DBD_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','DBD']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Db_anak =[];
            $Db_bayi =[];
            $laporanDb_anak =[];
           
            foreach ($DBD_anak as $Db_ank ) {
                array_push($Db_anak, [
                    'nama_dusun'=> $Db_ank->nama_dusun,
                    'anak'=> $Db_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($DBD_bayi as $Db_by ) {
                array_push($Db_bayi, [
                    'nama_dusun'=> $Db_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Db_by->jmlh
                    ]);
                }
            $DBD_bayi =array_merge($Db_anak,$Db_bayi);

            foreach ($DBD_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Db_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($DBD_bayi,"nama_dusun"));
                    $a = $DBD_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanDb_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Db_bayi,'nama_dusun')))){
                    array_push($laporanDb_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanDb_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanDb_anak,'nama_dusun'))) {
                        array_push($laporanDb_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanDb_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanDb_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Db_anak+=$jumlah['anak'];
                    $jmlh_Db_bayi+=$jumlah['bayi'];
                }
            }

            /**
             * mengelola laporan difteri meninggal
             * 
             */

            $difteri_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','difteri']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $difteri_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','difteri']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Af_anak =[];
            $Af_bayi =[];
            $laporanAf_anak =[];
           
            foreach ($difteri_anak as $Af_ank ) {
                array_push($Af_anak, [
                    'nama_dusun'=> $Af_ank->nama_dusun,
                    'anak'=> $Af_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($difteri_bayi as $Af_by ) {
                array_push($Af_bayi, [
                    'nama_dusun'=> $Af_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Af_by->jmlh
                    ]);
                }
            $difteri_bayi =array_merge($Af_anak,$Af_bayi);

            foreach ($difteri_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Af_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($difteri_bayi,"nama_dusun"));
                    $a = $difteri_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanAf_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Af_bayi,'nama_dusun')))){
                    array_push($laporanAf_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanAf_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanAf_anak,'nama_dusun'))) {
                        array_push($laporanAf_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanAf_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanAf_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Af_anak+=$jumlah['anak'];
                    $jmlh_Af_bayi+=$jumlah['bayi'];
                }
            }


            /**
             * mengelola laporan lain-lain meninggal
             * 
             */

            $lain_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Anak Balita'],['penyebab_kematian','=','lain-lain']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $lain_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where([['status','=','Bayi'],['penyebab_kematian','=','lain-lain']])->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Ln_anak =[];
            $Ln_bayi =[];
            $laporanLn_anak =[];
           
            foreach ($lain_anak as $Ln_ank ) {
                array_push($Ln_anak, [
                    'nama_dusun'=> $Ln_ank->nama_dusun,
                    'anak'=> $Ln_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($lain_bayi as $Ln_by ) {
                array_push($Ln_bayi, [
                    'nama_dusun'=> $Ln_by->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $Ln_by->jmlh
                    ]);
                }
            $lain_bayi =array_merge($Ln_anak,$Ln_bayi);

            foreach ($lain_bayi as $data) {
                if ((in_array($data['nama_dusun'],array_column($Ln_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($lain_bayi,"nama_dusun"));
                    $a = $lain_bayi[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanLn_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($Ln_bayi,'nama_dusun')))){
                    array_push($laporanLn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanLn_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanLn_anak,'nama_dusun'))) {
                        array_push($laporanLn_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanLn_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanLn_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_Ln_anak+=$jumlah['anak'];
                    $jmlh_Ln_bayi+=$jumlah['bayi'];
                }
            }

            $pdf = PDF::loadView('laporan.laporanMeninggal',compact(
            'laporanDi_anak','laporanPn_anak','laporanMa_anak','laporanCa_anak','laporanDb_anak','keterangan_laporan',
            'laporanAf_anak','laporanLn_anak','jmlh_Di_anak','jmlh_Di_bayi','jmlh_Pn_anak','jmlh_Pn_bayi','jmlh_Ma_anak','jmlh_Ma_bayi',
            'jmlh_Ca_anak','jmlh_Ca_bayi','jmlh_Db_anak','jmlh_Db_bayi','jmlh_Af_anak','jmlh_Af_bayi','jmlh_Ln_anak','jmlh_Ln_bayi'
            ));
            $pdf->setPaper('legal','landscape');

            return $pdf->stream('laporan_anak_meninggal_'.$tanggal.'.pdf');
        }
    }

}
