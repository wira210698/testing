@extends('layout/main')
@extends('layout.include.nav')

@section('title','Edit Data')

@section('container'.'')
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Edit Data Anak</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-body">
                                    <form method="post" action="/anak/{{$anak->id}}">
                                    @csrf
                                    @method('patch')
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama">NIK</label>
                                                    <input type="number" class="form-control @error('NIK') is-invalid @enderror form-control-sm" id="NIK" placeholder="NIK" name="NIK" value="{{$anak->NIK}}">
                                                    @error('NIK')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama_ibu">Nama Ibu</label>
                                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror form-control-sm" id="nama_ibu" placeholder="Nama Ibu" name="nama_ibu" value="{{$anak->nama_ibu}}">
                                                    @error('nama_ibu')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>    
                                            </div>                        
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nama_anak">Nama Anak</label>
                                                        <input type="text" class="form-control @error('nama_anak') is-invalid @enderror form-control-sm " id="nama_anak" placeholder="Nama Suami" name="nama_anak" value="{{$anak->nama_anak}}">
                                                        @error('nama_anak')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                            <select  name="status" class="form-control">
                                                                <option value="" >Pilihan</option>
                                                                <option value="Bayi" {{($anak->status=='Bayi')?'selected':''}}>Bayi</option>
                                                                <option value="Anak Balita" {{($anak->status=='Anak Balita')?'selected':''}}>Anak Balita</option>
                                                                <option value="DO" {{($anak->status=='DO')?'selected':''}}>DO(Drop Out)</option>
                                                            </select>
                                                    </div>     
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-4">
                                                <div class="form-group">
                                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror form-control-sm " id="tgl_lahir" name="tgl_lahir" value="{{$anak->tgl_lahir}}">
                                                    @error('tgl_lahir')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div>                                                 
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="umur">Umur</label>
                                                        <input type="number" class="form-control @error('umur') is-invalid @enderror form-control-sm  " id="umur" placeholder="Tahun" name="umur" value="{{$anak->umur}}">
                                                        @error('umur')
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
                                                                <option value="{{$dusun->id}}" {{($anak->dusun_id==$dusun->id)?'selected':''}}>Dusun {{$dusun->nama_dusun}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>  
                                                </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-2">
                                                    <div class="form-group">
                                                        <label class="fancy-radio">
									                    	<input name="jk" value="1" {{($anak->jk=='1')?'checked':''}} type="radio">
									                    	<span><i></i>Laki-Laki</span>
									                    </label>
                                                        <label class="fancy-radio">
									                    	<input name="jk" value="0" {{($anak->jk=='0')?'checked':''}} type="radio">
									                    	<span><i></i>Perempuan</span>
									                    </label>
                                                        <label class="fancy-checkbox mt-5">
                                                                <input type="checkbox" class="form-control @error('') is-invalid @enderror form-control-sm" id="" name="buku_KIA" value="1" {{($anak->buku_KIA>0)?'checked':''}}>
							            		                	<span>Buku KIA</span>
							            		                </label>
                                                    </div> 
                                                </div>  
                                            <div class="col-8 col-sm-10">
                                                <div class="form-group">
                                                    <label for="ket">Keterangan Tambahan</label>
                                                    <input type="text" class="form-control @error('ket') is-invalid @enderror form-control-sm" id="ket" placeholder="Masukan Keterangan Tambahan Jika Ada" name="ket" value="{{$anak->ket}}">
                                                    @error('ket')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div>                           
                                        <button type="submit" class="btn btn-primary " style="margin-left:235px;">Edit Data </button>
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
