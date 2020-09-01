<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use \App\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('username','password'))) {
            // dd(Auth::user());
            return redirect('/ibu');
        }
        return redirect('/login')->with('error','Data Username / Password Salah');
    }
    
    
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
    public function index()
    {
        $kader = User::all();
        return view('user.index',compact('kader'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'no_identitas' => 'required|max:16',
            'telp' => 'required|max:13',
            'img' => 'mimes:jpeg,png,jpg|max:2048',
            'username' => 'required|max:10|min:4|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($request->image =="") {
            $nama_file ="default.png";
        }else{
            $img = $request->file('image');
            $nama_file = rand().'.'.$img->getClientOriginalExtension();
            $img->move('img/foto', $nama_file);
        }
        $data_reg = array(
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_identitas' =>$request->no_identitas,
            'telp' => $request->telp,
            'image' => $nama_file,
            'role_id' => 'kader',
            'username' => $request->username,
            'password' => bcrypt($request->password)
        );
        User::create($data_reg);
        return redirect('/kader')->with('status','Data Berhasil di Tambah');
    }

    public function edit($id)
    {
        $user = User::find($id);
        // dd($user);
        return view('user.edit', compact('user'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'no_identitas' => 'required|max:16',
            'telp' => 'required|max:13',            
            'username' => 'required|max:10|min:4'
        ]);

        // dd($request->img_last);
        $data = User::where('id',$id)->first();

        if ($request->file('image') =="") {
            $img_last = $data->image;
            $data_img = array(
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_identitas' => $request->no_identitas,
                'telp' => $request->telp,
                'image' => $request->img_last,
                'username' => $request->username
            );

            User::whereId($id)->update($data_img);
        } else {
            $img = 'img/foto/'.$data->image;
            if (is_file($img) && $request->img_last != "default.png") {
                unlink($img);
            }
            $img = $request->file('image');
            $nama_file = rand().'.'.$img->getClientOriginalExtension();
            $img->move('img/foto', $nama_file);
            $data_img = array(
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_identitas' => $request->no_identitas,
                'telp' => $request->telp,
                'image' => $nama_file,
                'username' => $request->username
            );
            User::whereId($id)->update($data_img);
        }
        return redirect('kader')->with('status','Data Biodata '.$request->nama .' Berhasil di Ubah');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);
        $pass = ['password'=>bcrypt($request->password)];
        User::whereId($id)->update($pass);
        return redirect()->back()->with('status','Data Password '.$request->nama .' Berhasil di Ubah');
    }
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->back();
    }

    
}
