@extends('layout/main')
@extends('layout.include.nav')

@section('title','Edit Dokumentasi')

@section('container'.'') 
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Edit Data</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Data Dokumentasi</h3>
									<p class="panel-subtitle">Dokumentasi Kegiatan Puskesmas Pembantu dalam Pelayanan Posyandu Desa Lokasari</p>
								</div>
								<div class="panel-body">
                                     <form method="post" action="/doc/{{$data->id}}" enctype="multipart/form-data">
                                      @csrf
                                      @method('patch')
                                          <div class="row">
                                              <div class="col-8 col-sm-4">
                                                  <div class="form-group">
                                                      <label for="img">Gambar</label>
                                                      <input type="file" name="img">
                                                      <input type="hidden"  id="img"  name="img_last" value="{{$data->img}}">
                                                      <br>
                                                      
                                                  </div> 
                                               </div>     
                                               <div class="col-8 col-sm-8">
                                                      <img src="{{URL::to('/')}}/img/doc/{{$data->img}}" width="350">
                                                  </div> 
                                              </div>
                                          
                                           <div class="row">   
                                               <div class="col-8 col-sm-12">
                                                      <div class="form-group">
                                                          <label for="judul">Judul Dokumentasi</label>
                                                          <input type="text" class="form-control @error('judul') is-invalid @enderror form-control-sm " id="judul" placeholder="Judul" name="judul" value="{{$data->judul}}">
                                                          @error('judul')
                                                              <div class="invalid-feedback">{{$message}}</div> 
                                                          @enderror
                                                      </div>
                                                  </div>   
                                           </div>
                                           <button type="submit" class="btn btn-primary">Edit Data </button>
                                     </form>
									
								</div>
							</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

        @endsection
