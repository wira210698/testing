<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Ibu;
use App\KunjunganIbu;
use App\Persalinan;
use App\IbuMenyusui;
use App\Dusun;

class IbuController extends Controller
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
            $ibu= Ibu::where('nama_ibu','LIKE','%'.$request->search.'%')->orderByDesc('id')->paginate(9);
            return view('ibu.index', compact('ibu','key'));
        }else {
            $ibu= Ibu::orderByDesc('id')->paginate(9);
            return view('ibu.index', compact('ibu','key'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dusun = Dusun::all();
        return view('ibu.create',compact('dusun'));
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
            'NIK'=>'required|size:16|unique:reg_ibu',
            'nama_ibu'=>'required',
            'nama_suami'=>'required',
            'dusun_id'=>'required',
            'umur'=>'required|max:2',
            'usia_hamil'=>'required|max:2',
            'jrk_hamil'=>'required|max:2',
            'kehamilan_ke'=>'required|max:2',
            'bb'=>'required|max:3',
            'tb'=>'required|max:3',
            'td'=>'required|max:8'
        ]);
        Ibu::create($request->all());
        // return $request->all();
        return redirect('/ibu')->with('status','Data Berhasil di Tambah');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ibu= Ibu::find($id);
        $ibu->load(['kunjunganibu' => function ($q) {
        $q->orderBy('tgl_kunjungan', 'desc')->paginate(4,['*'],'kunjunganibu');}]);
        $ibu->load(['ibumenyusui' => function ($q) {
        $q->orderBy('tgl_nifas', 'desc')->paginate(4,['*'],'ibumenyusui');}]);
        $dusun= Dusun::all();
        return view('ibu.detail',compact('ibu','dusun'));
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ibu= Ibu::where('id',$id)->first();
        $dusun= Dusun::all();
        return view('ibu.edit',compact('ibu','dusun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $request->validate([
            'NIK'=>'required|size:16',
            'nama_ibu'=>'required',
            'nama_suami'=>'required',
            'dusun_id'=>'required',
            'umur'=>'required|max:2',
            'usia_hamil'=>'required|max:2',
            'jrk_hamil'=>'required|max:2',
            'kehamilan_ke'=>'required|max:2',
            'bb'=>'required|max:3',
            'tb'=>'required|max:3',
            'td'=>'required|max:8'
        ]);
        $ibu= Ibu::find($id);
        $ibu->update($request->all());
        return redirect('/ibu')->with('status','Data '.$request->nama_ibu.' Berhasil di Ubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ibu::where('id',$id)->delete();
        return redirect('/ibu')->with('status','Data Ibu Berhasil Hapus');
    }

    public function addKunjungan(Request $request, $id)
    {
        $request->validate([
            'tgl_kunjungan'=>'required',
            'ket'=>'required|min:8|max:100' 
        ]);
        $ibu = Ibu::find($id);
        $ibu->kunjunganibu()->create($request->all());
        return redirect()->back();
       

    }
    
    public function deleteKunjungan($id,$idK)
    {
        $ibu = Ibu::find($id);
        $ibu->kunjunganibu()->whereId($idK)->delete();
        return redirect()->back();
    }

    public function addPersalinan(Request $request, $id)
    {
        $request->validate([
            'tgl_persalinan'=>'required',
            'tng_penolong'=>'required',
            'jenis_kelahiran'=>'required'
        ]);
        $ibu = Ibu::find($id);
        // $ibu->kunjunganibu()->attach($request->tgl_kunjungan,$request->ket);
        $ibu->persalinan()->create($request->all());
        return redirect()->back();
    }

    public function deletePersalinan($id,$idK)
    {
        $ibu = Ibu::find($id);
        $ibu->persalinan()->whereId($idK)->delete();
        return redirect()->back();
    }

    public function addMenyusui(Request $request, $id)
    {
        $request->validate([
            'tgl_nifas'=>'required',
            'ket'=>'required|min:8|max:100',
            'periode_nifas'=>'required'
        ]);
        $ibu = Ibu::find($id);
        $ibu->ibumenyusui()->create($request->all());
        return redirect()->back();
    }
    public function deleteMenyusui($id,$idK)
    {
        $ibu = Ibu::find($id);
        $ibu->ibumenyusui()->whereId($idK)->delete();
        return redirect()->back();
    }

}
