<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\KeluargaBerencana;
use App\KunjunganKb;
use App\Dusun;

class KeluargaBerencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key="";
        if ($request->has('search')) {
            $key = $request->search;
            $kb= KeluargaBerencana::where('nama_ibu','LIKE','%'.$request->search.'%')->orderByDesc('id')->paginate(9);
            return view('KB.index', compact('kb','key'));
        }else {
            $kb= KeluargaBerencana::orderByDesc('id')->paginate(9);
            return view('KB.index', compact('kb','key'));
        }
        // return $dusun_id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dusun = Dusun::all();
        return view('KB.create',compact('dusun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'nama_ibu'=>'required',
            'nama_suami'=>'required',
            'umur'=>'required|min:1|max:2',
            'jmlh_anak'=>'required|min:0|max:2',
            'dusun_id'=>'required',
            'riwayat_penyakit'=>'required'
            
        ]);
        KeluargaBerencana::create($request->all());
        return redirect('/KB')->with('status','Data Berhasil di Tambah');
        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KeluargaBerencana  $keluargaBerencana
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $kb = KeluargaBerencana::find($id);
         $kb->load(['kunjungankb' => function ($q) {
        $q->orderBy('tgl_kunjungan', 'desc')->paginate(4,['*'],'kunjungankb');}]);
        return view('KB.detail',compact('kb'));
        // return $kunjungan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KeluargaBerencana  $keluargaBerencana
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kb= KeluargaBerencana::where('id',$id)->first();
        $dusun= Dusun::all();
        return view('KB.edit',compact('kb','dusun'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KeluargaBerencana  $keluargaBerencana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'nama_ibu'=>'required',
            'nama_suami'=>'required',
            'umur'=>'required|min:1|max:2',
            'jmlh_anak'=>'required|min:0|max:2',
            'dusun_id'=>'required',
            'riwayat_penyakit'=>'required'
            
        ]);
        if($request->has('gakin')){
            $gakin =$request->gakin;
        }else{
            $gakin =null;
        }
        if($request->has('faktor_resiko')){
            $faktor_resiko =$request->faktor_resiko;
        }else{
            $faktor_resiko =null;

        }
        $data =[
            'nama_ibu'=>$request->nama_ibu,
            'nama_suami'=>$request->nama_suami,
            'umur'=>$request->umur,
            'jmlh_anak'=>$request->jmlh_anak,
            'dusun_id'=>$request->dusun_id,
            'riwayat_penyakit'=>$request->riwayat_penyakit,
            'faktor_resiko' => $faktor_resiko,
            'gakin' => $gakin,
            'pasca_bersalin' => $request->pasca_bersalin,
            'ket' => $request->ket
            
        ];
        $kb= KeluargaBerencana::find($id);
        $kb->update($data);
        return redirect('/KB')->with('status','Data '.$request->nama_ibu.' Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KeluargaBerencana  $keluargaBerencana
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KeluargaBerencana::where('id',$id)->delete();
        return redirect('/KB')->with('status','Data KB Berhasil Hapus');
    }
    public function addKunjungan(Request $request, $id)
    {
        // $request->validate([
        //     'tgl_kunjungan'=>'required',
        //     'ket'=>'required|min:8|max:100' 
        // ]);
        $kb = KeluargaBerencana::find($id);
        // $ibu->kunjunganibu()->attach($request->tgl_kunjungan,$request->ket);
        $kb->kunjungankb()->create($request->all());
        return redirect()->back();
    }

    public function deleteKunjungan($id,$idK)
    {
        $kb = KeluargaBerencana::find($id);
        $kb->kunjungankb()->whereId($idK)->delete();
        return redirect()->back();

        //  $kunjungan = KunjunganKb::where('kb_id',$id)->delete($idK);
        // $kunjungan->whereId($idK)->delete();
        // return redirect()->back();
    }
}
