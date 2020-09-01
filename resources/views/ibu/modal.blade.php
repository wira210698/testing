<!-- Modal  Kunjungan -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h3 class="modal-title" id="exampleModalLabel">Form Data Kunjungan</h3>
		      </div>
		      <div class="modal-body">
		         <form  method="post" action="/ibu/{{$ibu->id}}/addKunjungan"  role="form" id="kunjunganibu">
                @csrf
                    <div class="form-group" >
                        <label for="usia_hamil">Usia Kehamilan Ibu</label>
                        <select  name="usia_hamil" class="form-control @error('usia_hamil') is-invalid @enderror" value="{{old('usia_hamil')}}" id="usia_hamil">
                            <option value="" selected>Pilihan</option>
                            <option value="0-12 minggu" {{(old('usia_hamil')=='0-12 minggu')?'selected':''}}>0-12 minggu</option>
                            <option value="13-24 minggu" {{(old('usia_hamil')=='13-24 minggu')?'selected':''}}>13-24 minggu</option>
                            <option value="25-27 minggu" {{(old('usia_hamil')=='25-27 minggu')?'selected':''}}>25-27 minggu</option>
                            <option value="28 minggu" {{(old('usia_hamil')=='28 minggu')?'selected':''}}>28 minggu</option>
                            <option value="24- <40 minggu" {{(old('usia_hamil')=='24- <40 minggu')?'selected':''}}>24- <40 minggu</option>
                        </select>
                        @error('usia_hamil')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>  
                    <div class="form-group">
                        <label for="tgl_kunjungan">Tanggal Kunjungan Ibu</label>
                        <input type="date" class="form-control @error('tgl_kunjungan') is-invalid @enderror" id="tgl_kunjungan"  name="tgl_kunjungan" value="{{old('tgl_kunjungan')}}">
                        @error('tgl_kunjungan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <input type="text" class="form-control @error('ket') is-invalid @enderror" id="ket" placeholder="Masukan Keterangan Kunjungan" name="ket" value="{{old('ket')}}">
                        @error('ket')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Simpan Data Kunjungan</button>
			</form>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
     
   
@yield('modalKunjungan')
<!-- END Modal Kunjungan -->

<!-- Modal Persalinan -->
<div class="modal fade modalPersalinan" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3>Form Persalinan</h3>
          </div>
          <div class="modal-body">
             <form method="post" action="/ibu/{{$ibu->id}}/addPersalinan" role="form" id="persalinanibu">
                @csrf
                    <div class="form-group">
                        <label for="tgl_persalinan">Tanggal Kunjungan Ibu</label>
                        <input type="date" class="form-control @error('tgl_persalinan') is-invalid @enderror" id="tgl_persalinan"  name="tgl_persalinan" value="{{old('tgl_persalinan')}}">
                        @error('tgl_persalinan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                       <label for="tng_penolong">Tenaga Penolong Persalinan</label>
                       <select  name="tng_penolong" class="form-control @error('tng_penolong') is-invalid @enderror" value="{{old('tng_penolong')}}" id="tng_penolong">
                            <option value="" selected>Pilihan</option>
                           <option value="Tenaga Kesehatan" {{(old('tng_penolong')=='Tenaga Kesehatan')?'selected':''}}>Tenaga Kesehatan</option>
                           <option value="Dukun Terlatih" {{(old('tng_penolong')=='Dukun Terlatih')?'selected':''}}>Dukun Terlatih</option>
                           <option value="Dukun Tak Terlatih" {{(old('tng_penolong')=='Dukun Tak Terlatih')?'selected':''}}>Dukun Tak Terlatih</option>
                       </select>
                        @error('tng_penolong')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="jenis_kelahiran">Jenis Melahirkan</label>
                        <select  name="jenis_kelahiran" class="form-control @error('jenis_kelahiran') is-invalid @enderror" value="{{old('jenis_kelahiran')}}" id="jenis_kelahiran">
                            <option value="" selected>Pilihan</option>
                            <option value="Lahir Mati" {{(old('jenis_kelahiran')=='Lahir Mati')?'selected':''}}>Lahir Mati</option>
                            <option value="Lahir Hidup -2.5" {{(old('jenis_kelahiran')=='Lahir Hidup -2.5')?'selected':''}}>Lahir Hidup Kurang 2.5kg  </option>
                            <option value="Lahir Hidup +2.5" {{(old('jenis_kelahiran')=='Lahir Hidup +2.5')?'selected':''}}>Lahir Hidup Lebih 2.5kg</option>
                            <option value="Keguguran" {{(old('jenis_kelahiran')=='Keguguran')?'selected':''}}>Keguguran</option>
                        </select>
                        @error('jenis_kelahiran')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>    
          </div>
          <div class="modal-footer">
		          <button type="submit" class="btn btn-primary">Simpan Data Persalinan</button>
          </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>
      </div>
</div>
@yield('modalPersalinan');
<!-- END Modal persalinan -->

<!--Modal Menyusui -->
<div class="modal fade modalMenyusui" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3>Form Ibu Menyusui</h3>
          </div>
          <div class="modal-body">
            <form method="post" action="/ibu/{{$ibu->id}}/addMenyusui" id="ibumenyusui">
                @csrf
                    <div class="form-group">
                        <label for="tgl_nifas">Tanggal Kunjungan Ibu</label>
                        <input type="date" class="form-control @error('tgl_nifas') is-invalid @enderror" id="tgl_nifas"  name="tgl_nifas" value="{{old('tgl_nifas')}}">
                        @error('tgl_nifas')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <input type="text" class="form-control @error('ket') is-invalid @enderror" id="ket" placeholder="Masukan Keterangan Kunjungan" name="ket" value="{{old('ket')}}">
                        @error('ket')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="periode_nifas">Periode Ibu Menyusui</label>
                        <select  name="periode_nifas" class="form-control" value="{{old('periode_nifas')}}" id="periode_nifas">
                            <option value="" selected>Pilihan</option>
                            <option value="6 jam-3 hari" {{(old('periode_nifas')=='6 jam-3 hari')?'selected':''}}>6 jam-3 hari{{(old('tng_penolong')=='Tenaga Kesehatan')?'selected':''}}</option>
                            <option value="8-12 hari" {{(old('periode_nifas')=='8-12 hari')?'selected':''}}>8-12 hari</option>
                            <option value="36-42 hari" {{(old('periode_nifas')=='36-42 hari')?'selected':''}}>36-42 hari</option>
                            <option value="42-2 tahun" {{(old('periode_nifas')=='42-2 tahun')?'selected':''}}>42-2 tahun</option>
                        </select>
                        @error('periode_nifas')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>    
          </div>
          <div class="modal-footer">
		          <button type="submit" class="btn btn-primary">Simpan Data</button>
            </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>

      </div>
    </div>
@yield('modalNifas');
<!-- END Modal Nifas -->

