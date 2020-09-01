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
								<div class="panel-heading">
									<h3 class="panel-title">Form Biodata Kader</h3>
									<p class="panel-subtitle">Edit Biodata Kader Posyandu </p>
								</div>
								<div class="panel-body">
                                    <form method="post" action="/kader/{{$user->id}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror form-control-sm" id="nama" placeholder="Nama Lengkap" name="nama" value="{{$user->nama}}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror form-control-sm" id="alamat" placeholder="Alamat Lengkap" name="alamat" value="{{$user->alamat}}">
                                                    @error('alamat')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>      
                                            </div>                        
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="no_identitas">No Identitas</label>
                                                        <input type="number" class="form-control @error('no_identitas') is-invalid @enderror form-control-sm " id="no_identitas" placeholder="KTP / NIP" name="no_identitas" value="{{$user->no_identitas}}">
                                                        @error('no_identitas')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="telp">Telp</label>
                                                        <input type="text" class="form-control @error('telp') is-invalid @enderror form-control-sm " id="telp" placeholder="No Telp" name="telp" value="{{$user->telp}}">
                                                        @error('telp')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                            </div> 
                                                <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control @error('username') is-invalid @enderror form-control-sm " id="username" placeholder="No username" name="username" value="{{$user->username}}">
                                                        @error('username')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="image">Foto Profil</label>
                                                        <input type="file" class="form-control form-control-sm" id="image" placeholder="Pilih gambar profil" name="image">
                                                        <input type="hidden"  id="img"  name="img_last" value="{{$user->image}}">
                                                    </div>
                                                </div>
                                                 <div class="col-8 col-sm-8">
                                                      <img src="{{URL::to('/')}}/img/foto/{{$user->image}}" width="150">
                                                  </div>                                    
                                        </div>                    
                                        <button type="submit" class="btn btn-primary">Edit Data </button>
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
