<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Anak;
use App\Dusun;
use App\KematianAnak;
use App\KondisiLahir;
use App\Imunisasi;

class AnakController extends Controller
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
            $anak= Anak::where('nama_anak','LIKE','%'.$request->search.'%')->orderByDesc('id')->paginate(8);
            return view('anak.index', compact('anak','key'));
        }else {
            $anak= Anak::orderByDesc('id')->paginate(8);
            return view('anak.index', compact('anak','key'));
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
        return view('anak.create',compact('dusun'));
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
            'NIK'=>'required|size:16|unique:reg_anak',
            'nama_ibu'=>'required',
            'nama_anak'=>'required',
            'status'=>'required',
            'tgl_lahir'=>'required',
            'umur'=>'required|max:3',
            'dusun_id'=>'required',
            'jk' =>'required'
        ]);
        
        Anak::create($request->all());
        // return $request->all();
        return redirect('/anak')->with('status','Data Berhasil di Tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anak= Anak::find($id);
        $anak->load(['kunjungananak' => function ($q) {
        $q->orderBy('tgl_kunjungan', 'desc')->paginate(4,['*'],'kunjungananak');}]);
        $anak->load(['prasekolah' => function ($q) {
        $q->orderBy('tgl_pelayanan', 'desc')->paginate(4,['*'],'prasekolah');}]);
        $anak->load(['imunisasi' => function ($q) {
        $q->orderBy('tgl_kunjungan', 'desc')->paginate(4,['*'],'imunisasi');}]);
        $imunisasi = Imunisasi::all();
        return view('anak.detail',compact('anak','imunisasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anak= Anak::where('id',$id)->first();
        $dusun= Dusun::all();
        return view('anak.edit',compact('anak','dusun'));
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
            'nama_anak'=>'required',
            'status'=>'required',
            'tgl_lahir'=>'required',
            'umur'=>'required|max:2',
            'dusun_id'=>'required',
            'jk' =>'required'
        ]);
        if($request->has('buku_KIA')){
            $buku_KIA =$request->buku_KIA;
        }else{
            $buku_KIA =null;
        }
        $data =[
            'NIK'=>$request->NIK,
            'nama_ibu'=>$request->nama_ibu,
            'nama_anak'=>$request->nama_anak,
            'status'=>$request->status,
            'tgl_lahir'=>$request->tgl_lahir,
            'umur'=>$request->umur,
            'dusun_id'=>$request->dusun_id,
            'jk' =>$request->jk,
            'buku_KIA'=>$buku_KIA,
            'ket'=>$request->ket
        ];
         $anak= Anak::find($id);
        $anak->update($data);
        return redirect('/anak')->with('status','Data '.$request->nama_anak.' Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Anak::where('id',$id)->delete();
        return redirect('/anak')->with('status','Data Ibu Berhasil Hapus');
    }

    // KUNJUNGAN ANAK
    public function addKunjungan(Request $request, $id)
    {
        $request->validate([
            'tgl_kunjungan'=>'required',
            'kd_pelayanan'=>'required',
            'tempat'=>'required',
            'umur'=>'required',
            'bb'=>'required',
            'kondisi_anak'=>'required',
            'ket'=>'max:100' 
        ]);
        $anak = Anak::find($id);
        $anak->kunjungananak()->create($request->all());
        return redirect()->back();
        // return $request;
    }

    public function deleteKunjungan($id,$idK)
    {
        $anak = Anak::find($id);
        $anak->kunjungananak()->whereId($idK)->delete();
        return redirect()->back();
    }

    // ANAK PRASEKOLAH
    public function addPrasekolah(Request $request, $id)
    {
        $request->validate([
            'tgl_pelayanan'=>'required',
            'tempat'=>'required',
            'status_gizi'=>'required'
        ]);
        $anak = Anak::find($id);
        $anak->prasekolah()->create($request->all());
        return redirect()->back();
    }

    public function deletePrasekolah($id,$idK)
    {
        $anak = Anak::find($id);
        $anak->prasekolah()->whereId($idK)->delete();
        return redirect()->back();
    }
    // KONDISI LAHIR
    public function addKondisiLahir(Request $request, $id)
    {
        $anak = Anak::find($id);
        if ($anak->kondisilahir) {
            return redirect()->back();
        }
        $request->validate([
            'tgl_pelayanan'=>'required',
            'tempat'=>'required',
            'kd_kondisi'=>'required',
            'kd_pelayanan'=>'required'
        ]);
        $anak->kondisilahir()->create($request->all());
        return redirect()->back();
    }

    public function deleteKondisiLahir($id,$idK)
    {
        $anak = Anak::find($id);
        $anak->kondisilahir()->whereId($idK)->delete();
        return redirect()->back();
    }


    // KEMATIAN ANAK

    public function addKematianAnak(Request $request, $id)
    {
        // $request->validate([
        //     'tgl_pelayanan'=>'required',
        //     'tempat'=>'required',
        //     'status_gizi'=>'required'
        // ]);
        $anak = Anak::find($id);
        $anak->kematiananak()->create($request->all());
        return redirect()->back();
    }

    public function deleteKematianAnak($id,$idK)
    {
        $anak = Anak::find($id);
        $anak->kematiananak()->whereId($idK)->delete();
        return redirect()->back();
    }
    
    /*
    *
    * Imunisasi
    *
    */
    public function addImunisasi(Request $request, $id){
        
        $anak = Anak::find($id);
        
        if($anak->imunisasi()->where('imunisasi_id',$request->imunisasi_id)->exists()){
            return redirect()->back();
        }
        $anak->imunisasi()->attach($request->imunisasi_id,['tgl_kunjungan'=> $request->tgl_kunjungan]);
        return redirect()->back();
        
    }
    public function deleteImunisasi($id,$idK)
    {
        DB::table('anak_imunisasi')->where('anak_id',$id)->where('imunisasi_id',$idK)->update(array('deleted_at'=>DB::raw('NOW()')));
        return redirect()->back();
    }

}

