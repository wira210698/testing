
<!--Modal kunjungan KB -->
<div class="modal fade modalKunjunganKB" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3>Form Kunjungan KB</h3>
          </div>
          <div class="modal-body">
            <form method="post" action="/KB/{{$kb->id}}/addKunjungan" role="form" id="kunjungankb">
                @csrf
                    <div class="form-group">
                        <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                        <input type="date" class="form-control @error('tgl_kunjungan') is-invalid @enderror" id="tgl_kunjungan"  name="tgl_kunjungan" value="{{old('tgl_kunjungan')}}">
                        @error('tgl_kunjungan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                        <label for="kategori_peserta">Kategori Peserta KB</label>
                        <select  name="kategori_peserta" class="form-control" value="{{old('kategori_peserta')}}" id="kategori_peserta">
                            <option value="" selected>Pilihan</option>
                            <option value="Peserta Baru" {{(old('kategori_peserta')=='Peserta Baru')?'selected':''}}>Peserta Baru</option>
                            <option value="Peserta Lama" {{(old('kategori_peserta')=='Peserta Lama')?'selected':''}}>Peserta Lama</option>
                            <option value="DO" {{(old('kategori_peserta')=='DO')?'selected':''}}>DO(Drop Out)</option>
                        </select>
                        @error('kategori_peserta')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>    
                    <div class="form-group" >
                        <label for="jenis_kb">Jenis Penggunaan Alat Kontrasepsi</label>
                        <select  name="jenis_kb" class="form-control" value="{{old('jenis_kb')}}" id="jenis_kb">
                            <option value="" selected>Pilihan</option>
                            <option value="IUD" {{(old('jenis_kb')=='IUD')?'selected':''}}>IUD</option>
                            <option value="MOW" {{(old('jenis_kb')=='MOW')?'selected':''}}>MOW</option>
                            <option value="MOP" {{(old('jenis_kb')=='MOP')?'selected':''}}>MOP</option>
                            <option value="Implan" {{(old('jenis_kb')=='Implan')?'selected':''}}>Implan</option>
                            <option value="Suntik" {{(old('jenis_kb')=='Suntik')?'selected':''}}>Suntik</option>
                            <option value="Pil KB" {{(old('jenis_kb')=='Pil KB')?'selected':''}}>Pil KB</option>
                            <option value="Kondom" {{(old('jenis_kb')=='Kondom')?'selected':''}}>Kondom</option>
                            <option value="Obat Vag" {{(old('jenis_kb')=='Obat Vag')?'selected':''}}>Obat Vag</option>
                            <option value="Lainnya" {{(old('jenis_kb')=='Lainnya')?'selected':''}}>Lainnya</option>
                        </select>
                        @error('jenis_kb')
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
		          <button type="submit" class="btn btn-primary">Simpan Data Nifas</button>
            </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>

      </div>
    </div>
@yield('modal');
<!-- END Kunjungan KB -->
