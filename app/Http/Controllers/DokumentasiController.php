<?php

namespace App\Http\Controllers;

use App\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumentasiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doc = Dokumentasi::where('kategori','=','doc')->orderByDesc('created_at')->paginate(9);
        // $doc = DB::table('tb_doc')->paginate(9);
        return view('home.index',compact('doc'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.create');
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
            'img' => 'required|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required'
        ]);
        

        
        $img = $request->file('img');
        $nama_file = rand().'.'.$img->getClientOriginalExtension();
        $img->move('img/doc', $nama_file);
        $data_img = array(
            'img' => $nama_file,
            'judul' => $request->judul,
            'kategori' => "doc",
            'subjek' => $request->subjek,
            'ket' => $request->ket
        );

        Dokumentasi::create($data_img);
        return redirect('doc');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Dokumentasi::whereId($id)->first();
        return view('home.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Dokumentasi::find($id);
        return view('home.edit',compact('data'));
    }
    public function ubah($id)
    {
        $data = Dokumentasi::find($id);
        return view('home.ubah',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'img' => 'mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required'
        ]);
        $data = Dokumentasi::where('id',$id)->first();

        if ($request->file('img') =="") {
            $img_last = $data->img;
            $data_img = array(
                'img' => $request->img_last,
                'judul' => $request->judul,
                'kategori' => $data->kategori,
                'subjek' => $request->subjek,
                'ket' => $request->ket
            );

            Dokumentasi::whereId($id)->update($data_img);
        } else {
            $img = 'img/doc/'.$data->img;
            if (is_file($img)) {
                unlink($img);
            }
            $img = $request->file('img');
            $nama_file = rand().'.'.$img->getClientOriginalExtension();
            $img->move('img/doc', $nama_file);
            $data_img = array(
                'img' => $nama_file,
                'judul' => $request->judul,
                'kategori' => $data->kategori,
                'subjek' => $request->subjek,
                'ket' => $request->ket
            );

            Dokumentasi::whereId($id)->update($data_img);
        }
        
        
        return redirect('doc');
        // return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Dokumentasi::find($id);
        $data->delete();
        return redirect('doc');
    }

    public function home(){
        $data = Dokumentasi::all();
        return view('home.home',compact('data'));
    }

    // public function fetch_data(Request $request)
    // {
    //     if($request->ajax()){
    //         $image = Dokumentasi::where('kategori','=','doc')->paginate(3);
    //         return view('home.home',compact('image'))->render();
    //     }
    // }
}
