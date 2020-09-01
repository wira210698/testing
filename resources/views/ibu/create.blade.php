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
                                <h2 >Form Tambah Data Ibu</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-body" style="margin-top:11px;">
                                    <form method="post" action="/ibu">
                                    @csrf

                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama">NIK Ibu</label>
                                                    <input type="number" class="form-control @error('NIK') is-invalid @enderror form-control-sm" id="NIK" placeholder="NIK" name="NIK" value="{{old('NIK')}}">
                                                    @error('NIK')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-8 col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama_ibu">Nama Ibu</label>
                                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror form-control-sm" id="nama_ibu" placeholder="Nama Ibu" name="nama_ibu" value="{{old('nama_ibu')}}">
                                                    @error('nama_ibu')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>      
                                            </div>                        
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nama_suami">Nama Suami</label>
                                                        <input type="text" class="form-control @error('nama_suami') is-invalid @enderror form-control-sm " id="nama_suami" placeholder="Nama Suami" name="nama_suami" value="{{old('nama_suami')}}">
                                                        @error('nama_suami')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="dusun_id">Alamat</label>
                                                            <select  name="dusun_id" class="form-control">
                                                                <option value="" >Pilihan</option>
                                                                @foreach($dusun as $dusun)
                                                                <option value="{{$dusun->id}}" {{(old('dusun_id')==$dusun->id)?'selected':''}}>Dusun {{$dusun->nama_dusun}}</option>
                                                                @endforeach
                                                            </select>
                                                             @error('dusun_id')
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
                                                        <label for="usia_hamil">Usia Kehamilan</label>
                                                        <input type="number" class="form-control @error('usia_hamil') is-invalid @enderror form-control-sm " id="usia_hamil" placeholder="Minggu" name="usia_hamil" value="{{old('usia_hamil')}}">
                                                        @error('usia_hamil')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                            <div class="col-8 col-sm-4">
                                                <div class="form-group">
                                                    <label for="kehamilan_ke">Kehamilan Ke-</label>
                                                    <input type="number" class="form-control @error('kehamilan_ke') is-invalid @enderror form-control-sm " id="kehamilan_ke" placeholder="Tahun" name="kehamilan_ke" value="{{old('kehamilan_ke')}}">
                                                    @error('kehamilan_ke')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div>                                                 
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="jrk_hamil">Jarak Kehamilan</label>
                                                        <input type="number" class="form-control @error('jrk_hamil') is-invalid @enderror form-control-sm " id="jrk_hamil" placeholder="Tahun" name="jrk_hamil" value="{{old('jrk_hamil')}}">
                                                        @error('jrk_hamil')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div>  
                                            <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="bb">Berat Badan Ibu Hamil</label>
                                                        <input type="number" class="form-control @error('bb') is-invalid @enderror form-control-sm " id="bb" placeholder="Kg " name="bb" value="{{old('bb')}}">
                                                        @error('bb')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div>
                                            <div class="col-8 col-sm-4">
                                                <div class="form-group">
                                                    <label for="tb">Tinggi Badan Ibu Hamil</label>
                                                    <input type="number" class="form-control @error('tb') is-invalid @enderror form-control-sm" id="tb" placeholder="Cm" name="tb" value="{{old('tb')}}">
                                                    @error('tb')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div>                          
                                        </div>
                                        <div class="row">                        
                                            <div class="col-8 col-sm-3">
                                                    <div class="form-group">
                                                        <label for="td">Tekanan Darah Ibu Hamil</label>
                                                        <input type="number" class="form-control @error('td') is-invalid @enderror form-control-sm" id="td" placeholder="mmHg" name="td" value="{{old('td')}}">
                                                        @error('td')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                            <div class="col-8 col-sm-3">
                                                <div class="form-group" >
                                                    <label for="p_resiko">Penanganan Faktor Resiko</label>
                                                    <select  name="p_resiko" class="form-control" value="{{old('p_resiko')}}">
                                                        <option value="-" selected>Pilihan</option>
                                                        <option value="TK">Tenaga Kesehatan</option>
                                                        <option value="NK">Non Tenaga Kesehatan</option>
                                                    </select>
                                                </div>    
                                            </div> 
                                            <div class="col-8 col-sm-3">
                                                    <div class="form-group">
                                                        <label for="tgl_p_resiko">Tanggal Penanganan Resiko</label>
                                                        <input type="date" class="form-control form-control-lg" id="tgl_p_resiko" placeholder=" Tanggal Penanganan Resiko" name="tgl_p_resiko" value="{{old('tgl_p_resiko')}}">
                                                    </div> 
                                                </div>  
                                            <div class="col-8 col-sm-3">
                                                <div class="form-group">
                                                    <label for="ket">Keterangan Tambahan</label>
                                                    <input type="text" class="form-control @error('ket') is-invalid @enderror form-control-sm" id="ket" placeholder="Masukan Keterangan Tambahan Jika Ada" name="ket" value="{{old('ket')}}">
                                                    @error('ket')
                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                    @enderror
                                                </div>     
                                            </div> 
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary text-center">Tambah Data </button>
                                            </div>                          
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
