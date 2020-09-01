<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imunisasi;
use DB;
class ImunisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imunisasi = Imunisasi::orderByDesc('ket')->paginate(8);
        $anak_imunisasi= DB::table('tb_dusun')->Join('reg_anak','tb_dusun.id','=','reg_anak.dusun_id')->
            Join('anak_imunisasi','reg_anak.id','=','anak_imunisasi.anak_id')->Join('tb_imunisasi','anak_imunisasi.imunisasi_id','=','tb_imunisasi.id')->whereNull('anak_imunisasi.deleted_at')->
            select('anak_imunisasi.id','reg_anak.nama_anak','tb_dusun.nama_dusun','anak_imunisasi.tgl_kunjungan','tb_imunisasi.nama_imunisasi')->paginate(4);
        return view('imunisasi.index', compact('imunisasi','anak_imunisasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Imunisasi::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Imunisasi::where('id',$id)->delete();
        return redirect('/imunisasi')->with('status','Data Berhasil Di Hapus');

    }
}
