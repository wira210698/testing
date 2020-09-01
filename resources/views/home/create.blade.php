@extends('layout/main')
@extends('layout.include.nav')

@section('title','Tambah Dokumentasi')

@section('container'.'') 
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Tambah Data</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Data Dokumentasi</h3>
									<p class="panel-subtitle">Dokumentasi Kegiatan Puskesmas Pembantu dalam Pelayanan Posyandu Desa Lokasari</p>
								</div>
								<div class="panel-body">
                                     <form method="post" action="/doc" enctype="multipart/form-data">
                                      @csrf
                                          <div class="row">
                                              <div class="col-8 col-sm-6">
                                                  <div class="form-group">
                                                      <label for="img">Gambar</label>
                                                      <input type="file" @error('img') is-invalid @enderror form-control-sm" id="img" placeholder="Nama Ibu" name="img" value="{{old('img')}}">
                                                      @error('img')
                                                          <div class="invalid-feedback">{{$message}}</div> 
                                                      @enderror
                                                  </div> 
                                               </div>     
                                               <div class="col-8 col-sm-6">
                                                      <div class="form-group">
                                                          <label for="judul">Judul Dokumentasi</label>
                                                          <input type="text" class="form-control @error('judul') is-invalid @enderror form-control-sm " id="judul" placeholder="Judul" name="judul" value="{{old('judul')}}">
                                                          @error('judul')
                                                              <div class="invalid-feedback">{{$message}}</div> 
                                                          @enderror
                                                      </div>
                                                  </div> 
                                              </div>
                                           <button type="submit" class="btn btn-primary">Tambah Data </button>
                                     </form>
									
								</div>
							</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

        @endsection
