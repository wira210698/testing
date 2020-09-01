
<!--Modal Tambah Jenis Imunisasi -->
<div class="modal fade modalImunisasi" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3>Form Tambah Jenis Imunisasi</h3>
          </div>
          <div class="modal-body">
            <form method="post" action="/imunisasi">
                @csrf                  
                    <div class="form-group">
                        <label for="nama_imunisasi">Nama Imunisasi</label>
                        <input type="text" class="form-control @error('nama_imunisasi') is-invalid @enderror" id="ket" placeholder="Masukan Keterangan Kunjungan" name="nama_imunisasi" value="{{old('nama_imunisasi')}}">
                        @error('nama_imunisasi')
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
		          <button type="submit" class="btn btn-primary">Simpan Data Imunisasi</button>
            </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>

      </div>
    </div>
@yield('modalImunisasi');
<!-- END imunisasi -->
