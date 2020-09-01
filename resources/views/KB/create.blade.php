@extends('layout/main')
@extends('layout.include.nav')
@section('title','Tambah Data')

@section('container'.'') 
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Tambah Data KB</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-body" style="margin-top:35px;">
                                     <form method="post" action="/KB">
                                      @csrf
            
                                          <div class="row">
                                              <div class="col-8 col-sm-6">
                                                  <div class="form-group">
                                                      <label for="nama_ibu">Nama Ibu</label>
                                                      <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror form-control-sm" id="nama_ibu" placeholder="Nama Ibu" name="nama_ibu" value="{{old('nama_ibu')}}">
                                                      @error('nama_ibu')
                                                          <div class="invalid-feedback">{{$message}}</div> 
                                                      @enderror
                                                  </div> 
                                               </div>     
                                               <div class="col-8 col-sm-6">
                                                      <div class="form-group">
                                                          <label for="nama_suami">Nama Suami</label>
                                                          <input type="text" class="form-control @error('nama_suami') is-invalid @enderror form-control-sm " id="nama_suami" placeholder="Nama Suami" name="nama_suami" value="{{old('nama_suami')}}">
                                                          @error('nama_suami')
                                                              <div class="invalid-feedback">{{$message}}</div> 
                                                          @enderror
                                                      </div>
                                                  </div> 
                                              </div>                        
                                         
            
                                           <div class="row">
                                               <div class="col-8 col-sm-4">
                                                       <div class="form-group">
                                                           <label for="umur">Umur</label>
                                                           <input type="number" class="form-control @error('umur') is-invalid @enderror form-control-sm  " id="umur" placeholder="Tahun" name="umur" value="{{old('umur')}}">
                                                           @error('umur')
                                                               <div class="invalid-feedback">{{$message}}</div> 
                                                           @enderror
                                                       </div>
                                                   </div>  
                                               <div class="col-8 col-sm-4">
                                                       <div class="form-group">
                                                           <label for="jmlh_anak">Jumlah Anak</label>
                                                           <input type="number" class="form-control @error('jmlh_anak') is-invalid @enderror form-control-sm " id="jmlh_anak" placeholder="Jumlah Anak" name="jmlh_anak" value="{{old('jmlh_anak')}}">
                                                           @error('jmlh_anak')
                                                               <div class="invalid-feedback">{{$message}}</div> 
                                                           @enderror
                                                       </div>
                                                   </div> 
                                               <div class="col-8 col-sm-4">
                                                 <div class="form-group">
                                                  <label for="dusun_id">Alamat</label>
                                                      <select  name="dusun_id" class="form-control">
                                                          <option value="" >Pilihan</option>
                                                          @foreach($dusun as $dusun)
                                                          <option value="{{$dusun->id}}" {{(old('dusun_id')==$dusun->id)?'selected':''}}>Dusun {{$dusun->nama_dusun}}</option>
                                                          @endforeach
                                                      </select>
                                                   </div>       
                                               </div>                                                 
                                           </div>
                                          
                                           <div class="row">                        
                                               <div class="col-8 col-sm-5">
                                                    <div class="form-group" >
                                                       <label for="riwayat_penyakit">Riwayat Penyakit</label>
                                                       <select  name="riwayat_penyakit" class="form-control" value="{{old('riwayat_penyakit')}}">
                                                           <option value="-" selected>Tidak Ada</option>
                                                           <option value="Anemia">Anemia</option>
                                                           <option value="Lila <23,5 cm">Lila <23,5 cm</option>
                                                           <option value="Penyakit Kronis">kencing manis, jantung, asma berat, malaria, TBC</option>
                                                           <option value="IMS">IMS (Infeksi Menular Seksual)</option>
                                                       </select>
                                                   </div>    
                                               </div> 
                                               <div class="col-8 col-sm-2">
                                                      <div class="form-group ">
                                                             <label class="fancy-checkbox mt-5">
                                                                <input type="checkbox" class="form-control @error('4T') is-invalid @enderror form-control-sm" id="4T" name="faktor_resiko" value="1">
							            		                	<span>Faktor Resiko (4T)</span>
							            		                </label>
                                                             <label class="fancy-checkbox">
                                                                <input type="checkbox" class="form-control @error('gakin') is-invalid @enderror form-control-sm" id="gakin" placeholder="Masukan Tekanan Darah Ibu Hamil" name="gakin" value="1">
							            		                	<span>GAKIN</span>
							            		                </label>
                                                       </div>
                                                   </div> 
                                                                         
                                               <div class="col-8 col-sm-5">
                                                       <div class="form-group">
                                                           <label for="pasca_bersalin">Tanggal Pasca Bersalin</label>
                                                           <input type="date" class="form-control form-control-lg" id="pasca_bersalin" placeholder=" Tanggal Penanganan Resiko" name="pasca_bersalin" value="{{old('pasca_bersalin')}}">
                                                       </div> 
                                                   </div>  
                                           </div>
                                           <div class="row">
                                                <div class="col-8 col-sm-12">
                                                    <label for="ket">Keterangan Tambahan</label>
                                                    <input type="text" class="form-control form-control-lg" id="ket" placeholder=" Keterangan Tambahan" name="ket" value="{{old('ket')}}">
                                                </div>
                                           </div>
								        </div>
                                      <div class="text-center" style="margin-bottom:15px;">
                                           <button type="submit" class="btn btn-primary">Tambah Data </button>
                                      </div>
                                </form>
							</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

        @endsection
