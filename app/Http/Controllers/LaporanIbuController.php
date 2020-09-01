<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ibu;
use App\KunjunganIbu;
use App\Persalinan;
use App\IbuMenyusui;
use App\Dusun;

class LaporanIbuController extends Controller
{
     public function report(Request $request)
    {
        if ($request->has('bulan')) {
            // $dusun = Dusun::has('Ibu')->with('ibu')->whereMonth('created_at','=',$request->bulan)->whereYear('created_at','=',$request->tahun)->get();
            
            $bulan_lalu;
            if ($request->bulan == '01') {
                $bulan_lalu = '01';
            }else{
                $bulan_lalu = $request->bulan - 1;
            }
            
            $dusun= Dusun::all();
            $kunjungan_bulan_ini = DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$request->bulan)->whereYear('tgl_kunjungan','=',$request->tahun)->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))
            ->groupBy('tb_dusun.nama_dusun')->
            get();

            $kunjungan_bulan_lalu= DB::table('tb_dusun')->leftJoin('reg_ibu','tb_dusun.id','=','reg_ibu.dusun_id')->
            leftJoin('tb_kunjungan_ibu','reg_ibu.id','=','tb_kunjungan_ibu.ibu_id')->
            whereMonth('tgl_kunjungan','=',$bulan_lalu)->whereYear('tgl_kunjungan','=',$request->tahun)->
            select('tb_dusun.nama_dusun',DB::raw('count(tb_kunjungan_ibu.usia_hamil) as jmlh'))->groupBy('tb_dusun.nama_dusun')->get();
            
            // $data = collect(['nama_dusun','jmlh']);   
            // $data_bulan_ini = $data->combine(
            //     foreach ($dusun as $dusun) {
            //         [$dusun->nama_dusun, '5'],
            //     }
            // );
            
            $K1standar = [];
            $bulan_ini =[];
            $kunjungan = [];

            foreach ($kunjungan_bulan_ini as $bulanIni) {
                array_push($kunjungan, ['nama_dusun' => $bulanIni->nama_dusun, 'jmlh'=> $bulanIni->jmlh]);
            }
            foreach ($dusun as $dusun) {
                for ($i=0; $i=$dusun->count() ; $i++) { 
                    if ( !empty($b->jmlh)) {
                        array_push($bulan_ini, [ 'jmlh'=> $b->jmlh]);
                    }
                }

                
                
                array_push($K1standar, [
                    'nama_dusun'=> $dusun->nama_dusun,
                    'bulan_ini'=> 10
                ]);
            }
            // foreach ($kunjungan_bulan_ini as $bulan_ini) {
            //     if ($bulan_ini->nama_dusun == $data['nama_dusun']) {
            //         array_push($data, [
            //             'jmlah'=> $bulan_ini->jmlh
            //         ]);
            //     }
            // }



            // return view('ibu.report', compact('dusun','kunjungan_bulan_ini','kunjungan_bulan_lalu'));
            return $kunjungan;
        }
        $dusun="";
        return view('ibu.report', compact('dusun'));
        // return $request;
    }
}
