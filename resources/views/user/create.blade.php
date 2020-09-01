@extends('layout/main')
@extends('layout.include.nav')

@section('title','Register Kader')

@section('container'.'')
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Data Kader</h2>
                            </div>
                            <div class="panel panel-headline">
								
								<div class="panel-body" style="margin-top:39px;">
                                    <form method="post" action="/kader" enctype="multipart/form-data">
                                    @csrf

                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror form-control-sm" id="nama" placeholder="Nama Lengkap" name="nama" value="{{old('nama')}}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror form-control-sm" id="alamat" placeholder="Alamat Lengkap" name="alamat" value="{{old('alamat')}}">
                                                    @error('alamat')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>      
                                            </div>                        
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="no_identitas">No Identitas</label>
                                                        <input type="number" class="form-control @error('no_identitas') is-invalid @enderror form-control-sm " id="no_identitas" placeholder="KTP / NIP" name="no_identitas" value="{{old('no_identitas')}}">
                                                        @error('no_identitas')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="telp">Telp</label>
                                                        <input type="number" class="form-control @error('telp') is-invalid @enderror form-control-sm " id="telp" placeholder="No Telp" name="telp" value="{{old('telp')}}">
                                                        @error('telp')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="image">Foto Profil</label>
                                                        <input type="file" class="form-control @error('image') is-invalid @enderror form-control-sm  " id="image" placeholder="Pilih gambar profil" name="image" value="{{old('image')}}">
                                                        @error('image')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div>                                    
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control @error('username') is-invalid @enderror form-control-sm " id="username" placeholder="Username" name="username" value="{{old('username')}}">
                                                        @error('username')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div>  
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror form-control-sm " id="password" placeholder="Password " name="password" value="{{old('password')}}">
                                                        @error('password')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div>
                                            <div class="col-8 col-sm-4">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Konfirmasi Password</label>
                                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror form-control-sm" id="password_confirmation" placeholder="Konfirmasi Password" name="password_confirmation" value="{{old('password_confirmation')}}">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div>                          
                                        </div>                           
                                        <button type="submit" class="btn btn-primary">Tambah Data </button>
                                        </div>
                                    </form>
								</div>
							</div>

                        </div>
                    </div>
                 </div>
            </div>
        </div>

        @endsection
