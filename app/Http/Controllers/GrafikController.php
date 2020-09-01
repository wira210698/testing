<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dusun;

class GrafikController extends Controller
{
    public function ibu(Request $request){
            $keterangan_grafik;
        
            $dusun = Dusun::all();
            $ReqBulanIni = date('m');
            $ReqTahunIni = date('Y');
            $bln_lalu_K;
            $bln_lalu_P;
            $bln_lalu_M;
            $jmlhKunjunganBlnini=0;
            $jmlhKunjunganBlnLalu=0;
            $jmlhPersalinanBlnini=0;
            $jmlhPersalinanBlnlalu=0;
            $jmlhMenyusuiBlnini=0;
            $jmlhMenyusuiBlnlalu=0;
            if ($request->bulan != "") {
                $ReqBulanIni = $request->bulan;
                $ReqTahunIni = $request->tahun;
                $bln_lalu_K = $request->bulan - 1;
                $bln_lalu_P = $request->bulan - 1;
                $bln_lalu_M = $request->bulan - 1;
            }else{
                $bln_lalu_K = $ReqBulanIni - 1;
                $bln_lalu_P = $ReqBulanIni - 1;
                $bln_lalu_M = $ReqBulanIni - 1;
            }

            if ($ReqBulanIni ==1) {
            $keterangan_grafik = "Januari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==2) {
                $keterangan_grafik = "Februari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==3) {
                $keterangan_grafik = "Maret ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==4) {
                $keterangan_grafik = "April ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==5) {
                $keterangan_grafik = "Mei ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==6) {
                $keterangan_grafik = "Juni ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==7) {
                $keterangan_grafik = "Juli ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==8) {
                $keterangan_grafik = "Agustus ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==9) {
                $keterangan_grafik = "September ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==10) {
                $keterangan_grafik = "Oktober ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==11) {
                $keterangan_grafik = "November ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==12) {
                $keterangan_grafik = "Desember ".$ReqTahunIni;
            }

            /**
             * mengelola laporan Kunjungan Ibu
             * 
             */
            $kunjungan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$ReqBulanIni)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->whereNull('tb_kunjungan_ibu.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$bln_lalu_K)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->whereNull('tb_kunjungan_ibu.deleted_at')->
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
                        return $a['bulan_ini'] <=> $b['bulan_ini'];
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
            whereMonth('tgl_persalinan','=',$ReqBulanIni)->whereYear('tgl_persalinan','=',$ReqTahunIni)->whereNull('tb_persalinan.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_persalinan.jenis_kelahiran) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $persalinan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_persalinan','reg_ibu.id','=','tb_persalinan.ibu_id')->
            whereMonth('tgl_persalinan','=',$bln_lalu_P)->whereYear('tgl_persalinan','=',$ReqTahunIni)->whereNull('tb_persalinan.deleted_at')->
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
            whereMonth('tgl_nifas','=',$ReqBulanIni)->whereYear('tgl_nifas','=',$ReqTahunIni)->whereNull('tb_ibu_menyusui.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_ibu_menyusui.periode_nifas) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $menyusui_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_ibu_menyusui','reg_ibu.id','=','tb_ibu_menyusui.ibu_id')->
            whereMonth('tgl_nifas','=',$bln_lalu_M)->whereYear('tgl_nifas','=',$ReqTahunIni)->whereNull('tb_ibu_menyusui.deleted_at')->
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
                        return $a['bulan_ini'] <=> $b['bulan_ini'];
                    });
            foreach ($laporanM as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlhMenyusuiBlnini+=$jumlah['bulan_ini'];
                    $jmlhMenyusuiBlnlalu+=$jumlah['bulan_lalu'];
                }
            }
            $kategoriK=[];
            $kategoriP=[];
            $kategoriM=[];
            $data_K_BI=[];
            $data_K_BL=[];
            $data_P_BI=[];
            $data_P_BL=[];
            $data_M_BI=[];
            $data_M_BL=[];
            foreach ($laporanK as $K) {
                if($K['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriK[]= $K['nama_dusun'];
                }
            }
            foreach ($laporanK as $K) {
                if($K['nama_dusun'] != "Luar Desa Lokasari"){
                $data_K_BI[]= $K['bulan_ini'];
                }
            }
            foreach ($laporanK as $K) {
                if($K['nama_dusun'] != "Luar Desa Lokasari"){
                $data_K_BL[]= $K['bulan_lalu'];
                }
            }

            //Data grafik melahirkan

            foreach ($laporanP as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriP[]= $P['nama_dusun'];
                }
            }
            foreach ($laporanP as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $data_P_BI[]= $P['bulan_ini'];
                }
            }
            foreach ($laporanP as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $data_P_BL[]= $P['bulan_lalu'];
                }
            }

            //Data grafik menyusui

            foreach ($laporanM as $M) {
                if($M['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriM[]= $M['nama_dusun'];
                }
            }
            foreach ($laporanM as $M) {
                if($M['nama_dusun'] != "Luar Desa Lokasari"){
                $data_M_BI[]= $M['bulan_ini'];
                }
            }
            foreach ($laporanM as $M) {
                if($M['nama_dusun'] != "Luar Desa Lokasari"){
                $data_M_BL[]= $M['bulan_lalu'];
                }
            }
            // dd($keterangan_grafik);
            return view('grafik.grafik_ibu', compact('kategoriK','data_K_BI','data_K_BL','kategoriP','data_P_BI','data_P_BL','kategoriM','data_M_BI','data_M_BL','keterangan_grafik','jmlhMenyusuiBlnini','jmlhPersalinanBlnini','jmlhKunjunganBlnini'));
        
    }

    public function kb(Request $request){
            
            $keterangan_grafik;

            $dusun = Dusun::all();
            $ReqBulanIni = date('m');
            $ReqTahunIni = date('Y');
            $jmlhKB_baru_mkjp=0;
            $jmlhKB_baru_nonmkjp=0;
            $jmlhKB_lama_mkjp=0;
            $jmlhKB_lama_nonmkjp=0;
            
           
            if ($request->bulan != "") {
                $ReqBulanIni = $request->bulan;
                $ReqTahunIni = $request->tahun;
            }

            if ($ReqBulanIni ==1) {
            $keterangan_grafik = "Januari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==2) {
                $keterangan_grafik = "Februari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==3) {
                $keterangan_grafik = "Maret ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==4) {
                $keterangan_grafik = "April ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==5) {
                $keterangan_grafik = "Mei ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==6) {
                $keterangan_grafik = "Juni ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==7) {
                $keterangan_grafik = "Juli ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==8) {
                $keterangan_grafik = "Agustus ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==9) {
                $keterangan_grafik = "September ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==10) {
                $keterangan_grafik = "Oktober ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==11) {
                $keterangan_grafik = "November ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==12) {
                $keterangan_grafik = "Desember ".$ReqTahunIni;
            }

            /**
             * mengelola laporan Kunjungan KB
             * 
             */
            $kunjungankb_baru_mkjp = DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$ReqBulanIni)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Baru')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_baru_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$ReqBulanIni)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->
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
            whereMonth('tgl_kunjungan','=',$ReqBulanIni)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->
            whereIn('jenis_kb',['IUD','MOW','Implant','Suntik'])->where('kategori_peserta','Peserta Lama')->whereNull('tb_kunjungan_kb.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_kb.jenis_kb) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungankb_lama_nonmkjp= DB::table('tb_dusun')->leftJoin('reg_keluarga_berencana','tb_dusun.id','=','reg_keluarga_berencana.dusun_id')->
            leftJoin('tb_kunjungan_kb','reg_keluarga_berencana.id','=','tb_kunjungan_kb.kb_id')->
            whereMonth('tgl_kunjungan','=',$ReqBulanIni)->whereYear('tgl_kunjungan','=',$ReqTahunIni)->
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

            $kategoriL=[];
            $kategoriB=[];
            $data_L_BI=[];
            $data_L_BL=[];
            $data_B_BI=[];
            $data_B_BL=[];
            
            foreach ($laporanL as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriL[]= $L['nama_dusun'];
                }
            }
            foreach ($laporanL as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $data_L_BI[]= $L['MKJP'];
                }
            }
            foreach ($laporanL as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $data_L_BL[]= $L['NON_MKJP'];
                }
            }

            //Data grafik melahirkan

            foreach ($laporanK as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriB[]= $P['nama_dusun'];
                }
            }
            foreach ($laporanK as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $data_B_BI[]= $P['MKJP'];
                }
            }
            foreach ($laporanK as $P) {
                if($P['nama_dusun'] != "Luar Desa Lokasari"){
                $data_B_BL[]= $P['NON_MKJP'];
                }
            }

            return view('grafik.grafik_KB', compact('kategoriL','data_L_BI','data_L_BL','kategoriB','data_B_BI','data_B_BL','keterangan_grafik','jmlhKB_baru_mkjp','jmlhKB_baru_nonmkjp','jmlhKB_lama_mkjp','jmlhKB_lama_nonmkjp'));
            
    }

    public function anak(Request $request){
            $keterangan_grafik;
            $dusun = Dusun::all();
            $ReqBulanIni = date('m');
            $ReqTahunIni = date('Y');
            if ($request->bulan != "") {
                $ReqBulanIni = $request->bulan;
                $ReqTahunIni = $request->tahun;
            }

            if ($ReqBulanIni ==1) {
            $keterangan_grafik = "Januari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==2) {
                $keterangan_grafik = "Februari ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==3) {
                $keterangan_grafik = "Maret ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==4) {
                $keterangan_grafik = "April ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==5) {
                $keterangan_grafik = "Mei ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==6) {
                $keterangan_grafik = "Juni ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==7) {
                $keterangan_grafik = "Juli ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==8) {
                $keterangan_grafik = "Agustus ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==9) {
                $keterangan_grafik = "September ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==10) {
                $keterangan_grafik = "Oktober ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==11) {
                $keterangan_grafik = "November ".$ReqTahunIni;
            }elseif ($ReqBulanIni ==12) {
                $keterangan_grafik = "Desember ".$ReqTahunIni;
            }

            $jmlh_K_anak=0;
            $jmlh_K_bayi=0;
            $jmlh_P_anak_L=0;
            $jmlh_P_anak_P=0;
            $jmlh_I_anak=0;
            $jmlh_I_bayi=0;
            $jmlh_L_bayi_L=0;
            $jmlh_L_bayi_P=0;
            $jmlh_Di_anak=0;
            $jmlh_Di_bayi=0;


            
            $keterangan_laporan = $request->all();
           
            /**
             * mengelola laporan Kunjungan Anak dan bayi
             * 
             */
            $kunjungan_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_kunjungan_anak','reg_anak.id','=','tb_kunjungan_anak.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->whereNull('tb_kunjungan_anak.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_anak.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $K_anak =[];
            $K_bayi =[];
            $laporanK_anak =[];
           
            foreach ($kunjungan_anak as $K_anakL ) {
                array_push($K_anak, [
                    'nama_dusun'=> $K_anakL->nama_dusun,
                    'anak'=> $K_anakL->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($kunjungan_bayi as $K_anakP ) {
                array_push($K_bayi, [
                    'nama_dusun'=> $K_anakP->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $K_anakP->jmlh
                    ]);
                }
            $kunjungan_anak =array_merge($K_anak,$K_bayi);

            foreach ($kunjungan_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($K_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($kunjungan_anak,"nama_dusun"));
                    $a = $kunjungan_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanK_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($K_bayi,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanK_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanK_anak,'nama_dusun'))) {
                        array_push($laporanK_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanK_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanK_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_K_anak+=$jumlah['anak'];
                    $jmlh_K_bayi+=$jumlah['bayi'];
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
            $imunisasi_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Anak Balita')->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $imunisasi_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            where('status','Bayi')->whereNull('anak_imunisasi.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(anak_imunisasi.imunisasi_id) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $I_anak =[];
            $I_bayi =[];
            $laporanI_anak =[];
           
            foreach ($imunisasi_anak as $I_anakL ) {
                array_push($I_anak, [
                    'nama_dusun'=> $I_anakL->nama_dusun,
                    'anak'=> $I_anakL->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($imunisasi_bayi as $I_anakP ) {
                array_push($I_bayi, [
                    'nama_dusun'=> $I_anakP->nama_dusun,
                    'anak'=> 0,
                    'bayi'=> $I_anakP->jmlh
                    ]);
                }
            $imunisasi_anak =array_merge($I_anak,$I_bayi);

            foreach ($imunisasi_anak as $data) {
                if ((in_array($data['nama_dusun'],array_column($I_bayi,'nama_dusun')))&&($data['bayi']!=0)) {
                    $nonmkjp_b = array("bayi"=>$data['bayi']);
                    $key =array_search($data['nama_dusun'],array_column($imunisasi_anak,"nama_dusun"));
                    $a = $imunisasi_anak[$key];
                    $ubahBL = array_replace($a,$nonmkjp_b);
                    array_push($laporanI_anak,$ubahBL);
                    
                }elseif(($data['anak']!=0)&&(!in_array($data['nama_dusun'],array_column($I_bayi,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }elseif(($data['bayi']!=0)&&(!in_array($data['nama_dusun'],array_column($bulanini,'nama_dusun')))){
                    array_push($laporanI_anak, [
                        'nama_dusun'=> $data['nama_dusun'],
                        'anak'=>$data['anak'],
                        'bayi'=> $data['bayi']
                    ]);
                }
            }
             foreach ($dusun as $dsn) {
                    if (!in_array($dsn->nama_dusun,array_column($laporanI_anak,'nama_dusun'))) {
                        array_push($laporanI_anak, [
                            'nama_dusun'=> $dsn->nama_dusun,
                            'anak'=> 0,
                            'bayi'=> 0
                        ]);
                    }
                }
             usort($laporanI_anak,function($a, $b) {
                        return $a['nama_dusun'] <=> $b['nama_dusun'];
                    });
            foreach ($laporanI_anak as $jumlah) {
                if($jumlah['nama_dusun']!="Luar Desa Lokasari"){
                    $jmlh_I_anak+=$jumlah['anak'];
                    $jmlh_I_bayi+=$jumlah['bayi'];
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

            $M_anak = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where('status','=','Anak Balita')->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            $M_bayi = DB::table('tb_dusun')->leftJoin('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            leftJoin('tb_anak_meninggal','reg_anak.id','=','tb_anak_meninggal.anak_id')->
            whereMonth('tgl_kematian','=',$request->bulan)->whereYear('tgl_kematian','=',$request->tahun)->where('status','=','Bayi')->
            whereNull('tb_anak_meninggal.deleted_at')->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_anak_meninggal.tempat) as jmlh'))->groupBy('tb_dusun.nama_dusun')->
            get();

            
            $Di_anak =[];
            $Di_bayi =[];
            $laporanDi_anak =[];
           
            foreach ($M_anak as $Di_ank ) {
                array_push($Di_anak, [
                    'nama_dusun'=> $Di_ank->nama_dusun,
                    'anak'=> $Di_ank->jmlh,
                    'bayi'=> 0
                    ]);
                }
            foreach ($M_bayi as $Di_by ) {
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
            
           
            $kategoriK=[];
            $data_K_BI=[];
            $data_K_BL=[];
            $kategoriL=[];
            $data_L_BI=[];
            $data_L_BL=[];
            $kategoriP=[];
            $data_P_BI=[];
            $data_P_BL=[];
            $kategoriI=[];
            $data_I_BI=[];
            $data_I_BL=[];
            $kategoriM=[];
            $data_M_BI=[];
            $data_M_BL=[];

            //kunjungan anak bayi

            foreach ($laporanK_anak as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriK[]= $L['nama_dusun'];
                }
            }
            foreach ($laporanK_anak as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $data_K_BI[]= $L['anak'];
                }
            }
            foreach ($laporanK_anak as $L) {
                if($L['nama_dusun'] != "Luar Desa Lokasari"){
                $data_K_BL[]= $L['bayi'];
                }
            }

            //kondisi lahir bayi

            foreach ($laporanL_bayi as $La) {
                if($La['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriL[]= $La['nama_dusun'];
                }
            }
            foreach ($laporanL_bayi as $La) {
                if($La['nama_dusun'] != "Luar Desa Lokasari"){
                $data_L_BI[]= $La['L'];
                }
            }
            foreach ($laporanL_bayi as $La) {
                if($La['nama_dusun'] != "Luar Desa Lokasari"){
                $data_L_BL[]= $La['P'];
                }
            }

            //prasekolah

            foreach ($laporanP_anak as $Pr) {
                if($Pr['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriP[]= $Pr['nama_dusun'];
                }
            }
            foreach ($laporanP_anak as $Pr) {
                if($Pr['nama_dusun'] != "Luar Desa Lokasari"){
                $data_P_BI[]= $Pr['L'];
                }
            }
            foreach ($laporanP_anak as $Pr) {
                if($Pr['nama_dusun'] != "Luar Desa Lokasari"){
                $data_P_BL[]= $Pr['P'];
                }
            }

            //Imunisasi anak

            foreach ($laporanI_anak as $Im) {
                if($Im['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriI[]= $Im['nama_dusun'];
                }
            }
            foreach ($laporanI_anak as $Im) {
                if($Im['nama_dusun'] != "Luar Desa Lokasari"){
                $data_I_BI[]= $Im['anak'];
                }
            }
            foreach ($laporanI_anak as $Im) {
                if($Im['nama_dusun'] != "Luar Desa Lokasari"){
                $data_I_BL[]= $Im['bayi'];
                }
            }

            //anak meninggal

            foreach ($laporanDi_anak as $Me) {
                if($Me['nama_dusun'] != "Luar Desa Lokasari"){
                $kategoriM[]= $Me['nama_dusun'];
                }
            }
            foreach ($laporanDi_anak as $Me) {
                if($Me['nama_dusun'] != "Luar Desa Lokasari"){
                $data_M_BI[]= $Me['anak'];
                }
            }
            foreach ($laporanDi_anak as $Me) {
                if($Me['nama_dusun'] != "Luar Desa Lokasari"){
                $data_M_BL[]= $Me['bayi'];
                }
            }

            // dd($kategoriK,$data_K_BI,$data_K_BL);
            return view('grafik.grafik_anak', compact('kategoriK','data_K_BI','data_K_BL','kategoriL','data_L_BI','data_L_BL','kategoriP','data_P_BI','data_P_BL','kategoriI','data_I_BI','data_I_BL'
            ,'kategoriM','data_M_BI','data_M_BL','keterangan_grafik','jmlh_K_anak','jmlh_K_bayi','jmlh_P_anak_L','jmlh_P_anak_P','jmlh_I_anak','jmlh_I_bayi'
            ,'jmlh_L_bayi_L','jmlh_L_bayi_P','jmlh_Di_anak','jmlh_Di_bayi'));

    }
}
