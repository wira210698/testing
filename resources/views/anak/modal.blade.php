<!-- Modal  Kunjungan -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h3 class="modal-title" id="exampleModalLabel">Form Data Kunjungan Anak Balita / Bayi</h3>
		      </div>
		      <div class="modal-body">
		         <form id="formKunjungan" method="post" action="/anak/{{$anak->id}}/addKunjungan">
                @csrf
                    <div class="form-group">
                        <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                        <input type="date" class="form-control @error('tgl_kunjungan') is-invalid @enderror" id="tgl_kunjungan"  name="tgl_kunjungan" value="{{old('tgl_kunjungan')}}">
                        @error('tgl_kunjungan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="kd_pelayanan">Pelayanan yang di berikan</label>
                        <select  name="kd_pelayanan" class="form-control @error('kd_pelayanan') is-invalid @enderror" value="{{old('kd_pelayanan')}}" id="kd_pelayanan">
                            <option value="" selected>Pilihan</option>
                            <option value="D" {{(old('kd_pelayanan')=='D')?'selected':''}}>Pelayanan Pertama</option>
                            <option value="D 2x" {{(old('kd_pelayanan')=='D 2x')?'selected':''}}>Pelayanan ke 2 & 3</option>
                            <option value="D 4x" {{(old('kd_pelayanan')=='D 4x')?'selected':''}}>Pelayanan Ke 4+</option>
                            <option value="*" {{(old('kd_pelayanan')=='*')?'selected':''}}>Anak/Bayi dinyatakan Sehat</option>
                            @if($anak->status == "Anak Balita")
                            <option value="M" {{(old('kd_pelayanan')=='M')?'selected':''}}>Anak Sakit Menndapatkan Pelayanan MTBS</option>
                            <option value="S" {{(old('kd_pelayanan')=='S')?'selected':''}}>Anak Sakit Tdk Menndapatkan Pelayanan MTBS</option>
                            <option value="LT" {{(old('kd_pelayanan')=='LT')?'selected':''}}>Pengobatan Levo- Tiroksin</option>
                            <option value="EID+ISERO+" {{(old('kd_pelayanan')=='EID+ISERO+')?'selected':''}}>Pemeriksaan HIV pada Anak > 18 Bulan</option>
                            <option value="ARV" {{(old('kd_pelayanan')=='ARV')?'selected':''}}>Pengobatan ARV</option>
                            <option value="PPK" {{(old('kd_pelayanan')=='PPK')?'selected':''}}>Pengobatan Profilaksis Kotrimoksazol</option>
                            <option value="A" {{(old('kd_pelayanan')=='A')?'selected':''}}>Pemberian Vitamin A</option>
                            @else
                            <option value="IMD*" {{(old('kd_pelayanan')=='IMD')?'selected':''}}>Pemberian Inisiasi Menyusui Dini</option>
                            <option value="Vit K1" {{(old('kd_pelayanan')=='Vit K1')?'selected':''}}>Pemberian Vitamin K1</option>
                            <option value="SHK+" {{(old('kd_pelayanan')=='SHK+')?'selected':''}}>Hasil Skrining Positif</option>
                            <option value="SHK-" {{(old('kd_pelayanan')=='SHK-')?'selected':''}}>Hasil Skrining Negatif</option>
                            <option value="HK+" {{(old('kd_pelayanan')=='HK+')?'selected':''}}>Hasil Tes Konfirmasi Positif</option>
                            <option value="HK-" {{(old('kd_pelayanan')=='HK-')?'selected':''}}>Hasil Tes Konfirmasi Negatif</option>
                            <option value="LT" {{(old('kd_pelayanan')=='LT')?'selected':''}}>Pengobatan Levo- Tiroksin</option>
                            <option value="PR" {{(old('kd_pelayanan')=='PR')?'selected':''}}>Pelayanan Standar lebih dari 4x kunjungan</option>
                            <option value="E1" {{(old('kd_pelayanan')=='E1')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 1</option>
                            <option value="E2" {{(old('kd_pelayanan')=='E2')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 2</option>
                            <option value="E3" {{(old('kd_pelayanan')=='E3')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 3</option>
                            <option value="E4" {{(old('kd_pelayanan')=='E4')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 4</option>
                            <option value="E5" {{(old('kd_pelayanan')=='E5')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 5</option>
                            <option value="E6" {{(old('kd_pelayanan')=='E6')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 6</option>
                            @endif
                        </select>
                        @error('kd_pelayanan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div> 
                    <div class="form-group" >
                       <label for="tempat">Tempat Pelayanan</label>
                       <select  name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{old('tempat')}}" id="tempat">
                            <option value="" selected>Pilihan</option>
                           <option value="Puskesmas/Pustu" {{(old('tempat')=='Puskesmas/Pustu')?'selected':''}}>Puskesmas/Pustu</option>
                           <option value="Polindes" {{(old('tempat')=='Polindes')?'selected':''}}>Polindes</option>
                           <option value="Posyandu" {{(old('tempat')=='Posyandu')?'selected':''}}>Posyandu</option>
                           <option value="Kunjungan Rumah" {{(old('tempat')=='Kunjungan Rumah')?'selected':''}}>Kunjungan Rumah</option>
                           <option value="Unit Pelayanan Swasta" {{(old('tempat')=='Unit Pelayanan Swasta')?'selected':''}}>Unit Pelayanan Swasta</option>
                           <option value="Rumah Sakit" {{(old('tempat')=='Rumah Sakit')?'selected':''}}>Rumah Sakit</option>
                       </select>
                        @error('tempat')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="umur">Umur</label>
                        <input type="number" class="form-control @error('umur') is-invalid @enderror" id="umur" placeholder="Minggu" name="umur" value="{{old('umur')}}">
                        @error('umur')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bb">Berat Badan</label>
                        <input type="number" class="form-control @error('bb') is-invalid @enderror" id="bb" placeholder="Gram" name="bb" value="{{old('bb')}}">
                        @error('bb')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                       <label for="kondisi_anak">Kondisi Anak</label>
                       <select  name="kondisi_anak" class="form-control @error('kondisi_anak') is-invalid @enderror" value="{{old('kondisi_anak')}}">
                            <option value="" selected>Pilihan</option>
                           <option value="N" {{(old('kondisi_anak')=='N')?'selected':''}}>Berat Badan Naik(N)</option>
                           <option value="T" {{(old('kondisi_anak')=='T')?'selected':''}}>Berat Badan Tetap(T)</option>
                           <option value="O" {{(old('kondisi_anak')=='O')?'selected':''}}>Tidak Ditimbang Bulan Lalu(O)</option>
                           <option value="B" {{(old('kondisi_anak')=='B')?'selected':''}}>Baru Pertama Timbang(B)</option>
                       </select>
                        @error('kondisi_anak')
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

<!-- Modal Prasekolah -->
<div class="modal fade modalPrasekolah" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
            <h3>Form Kunjungan Anak Prasekolah</h3>
          </div>
          <div class="modal-body">
             <form method="post" action="/anak/{{$anak->id}}/addPrasekolah" role="form" id="formPrasekolah">
                @csrf
                    <div class="form-group">
                        <label for="tgl_pelayanan">Tanggal Kunjungan</label>
                        <input type="date" class="form-control @error('tgl_pelayanan') is-invalid @enderror" id="tgl_pelayanan"  name="tgl_pelayanan" value="{{old('tgl_pelayanan')}}">
                        @error('tgl_pelayanan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                       <label for="tempat">Tempat Pelayanan</label>
                       <select  name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{old('tempat')}}" id="tempat">
                            <option value="" selected>Pilihan</option>
                           <option value="Puskesmas/Pustu" {{(old('tempat')=='Puskesmas/Pustu')?'selected':''}}>Puskesmas/Pustu</option>
                           <option value="Polindes" {{(old('tempat')=='Polindes')?'selected':''}}>Polindes</option>
                           <option value="Posyandu" {{(old('tempat')=='Posyandu')?'selected':''}}>Posyandu</option>
                           <option value="Kunjungan Rumah" {{(old('tempat')=='Kunjungan Rumah')?'selected':''}}>Kunjungan Rumah</option>
                           <option value="Unit Pelayanan Swasta" {{(old('tempat')=='Unit Pelayanan Swasta')?'selected':''}}>Unit Pelayanan Swasta</option>
                           <option value="Rumah Sakit" {{(old('tempat')=='Rumah Sakit')?'selected':''}}>Rumah Sakit</option>
                       </select>
                        @error('tempat')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="status_gizi">Status Gizi</label>
                        <select  name="status_gizi" class="form-control @error('status_gizi') is-invalid @enderror" value="{{old('status_gizi')}}" id="status_gizi">
                            <option value="" selected>Pilihan</option>
                            <option value="Kurus Sekali" {{(old('status_gizi')=='Ks')?'selected':''}}>Kurus Sekali</option>
                            <option value="Kurus" {{(old('status_gizi')=='K')?'selected':''}}>Kurus  </option>
                            <option value="Normal" {{(old('status_gizi')=='Normal')?'selected':''}}>Normal  </option>
                            <option value="Gemuk" {{(old('status_gizi')=='Gemuk')?'selected':''}}>Gemuk  </option>
                            <option value="Hasil SDITK Sesuai" {{(old('status_gizi')=='Hasil SDITK Sesuai')?'selected':''}}>Hasil SDITK Sesuai  </option>
                            <option value="Hasil SDITK Meragukan" {{(old('status_gizi')=='Hasil SDITK Meragukan')?'selected':''}}>Hasil SDITK Meragukan  </option>
                            <option value="Hasil SDITK Penyimpangan" {{(old('status_gizi')=='Hasil SDITK Penyimpangan')?'selected':''}}>Hasil SDITK Penyimpangan  </option>
                        </select>
                        @error('status_gizi')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                        <label class="fancy-checkbox" style="margin-top:8px;">
                            <input type="checkbox" class="form-control @error('') is-invalid @enderror form-control-sm" id="" name="pemberian_arv" value="1" {{(old('pemberian_arv')>0)?'checked':''}}>
                            <span>Pemberian ARV</span>
                        </label>
                    </div>    
          </div>
          <div class="modal-footer">
		          <button type="submit" class="btn btn-primary">Simpan Data Prasekolah</button>
          </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>
      </div>
</div>
@yield('modalPrasekolah');
<!-- END Modal Prasekolah -->


<!-- Modal KondisiLahir -->
<div class="modal fade modalKondisiLahir" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        <span aria-hidden="true">&times;</span>
		    </button>
            <h3>Form Kondisi Lahir Bayi</h3>
          </div>
          <div class="modal-body">
             <form method="post" action="/anak/{{$anak->id}}/addKondisiLahir" id="formKondisiLahir">
                @csrf
                    <div class="form-group">
                        <label for="tgl_pelayanan">Tanggal Kelahiran</label>
                        <input type="date" class="form-control @error('tgl_pelayanan') is-invalid @enderror" id="tgl_pelayanan"  name="tgl_pelayanan" value="{{old('tgl_pelayanan')}}">
                        @error('tgl_pelayanan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                       <label for="tempat">Tempat Pelayanan</label>
                       <select  name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{old('tempat')}}" id="tempat">
                            <option value="" selected>Pilihan</option>
                           <option value="Puskesmas/Pustu" {{(old('tempat')=='Puskesmas/Pustu')?'selected':''}}>Puskesmas/Pustu</option>
                           <option value="Polindes" {{(old('tempat')=='Polindes')?'selected':''}}>Polindes</option>
                           <option value="Posyandu" {{(old('tempat')=='Posyandu')?'selected':''}}>Posyandu</option>
                           <option value="Rumah" {{(old('tempat')=='Rumah')?'selected':''}}>Rumah</option>
                           <option value="Unit Pelayanan Swasta" {{(old('tempat')=='Unit Pelayanan Swasta')?'selected':''}}>Unit Pelayanan Swasta</option>
                           <option value="Rumah Sakit" {{(old('tempat')=='Rumah Sakit')?'selected':''}}>Rumah Sakit</option>
                           <option value="Lain-lain" {{(old('tempat')=='Lain-lain')?'selected':''}}>Lain-lain</option>
                       </select>
                        @error('tempat')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="kd_kondisi">Kondisi Bayi</label>
                        <select  name="kd_kondisi" class="form-control @error('kd_kondisi') is-invalid @enderror" value="{{old('kd_kondisi')}}" id="kd_kondisi">
                            <option value="" selected>Pilihan</option>
                            <option value="Sehat" {{(old('kd_kondisi')=='Sehat')?'selected':''}}>Sehat</option>
                            <option value="Asfiksia" {{(old('kd_kondisi')=='Asfiksia')?'selected':''}}>Asfiksia</option>
                            <option value="Trauma Lahir" {{(old('kd_kondisi')=='Trauma Lahir')?'selected':''}}>Trauma Lahir</option>
                            <option value="Infeksi" {{(old('kd_kondisi')=='Infeksi')?'selected':''}}>Infeksi</option>
                            <option value="Kelainan Kongenital" {{(old('kd_kondisi')=='Kelainan Kongenital')?'selected':''}}>Kelainan Kongenital  </option>
                            <option value="Hipotermi" {{(old('kd_kondisi')=='Hipotermi')?'selected':''}}>Hipotermi  </option>
                            <option value="Lain-lain" {{(old('kd_kondisi')=='Lain-lain')?'selected':''}}>Lain-lain  </option>
                        </select>
                        @error('kd_kondisi')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>  
                      <div class="form-group" >
                        <label for="kd_pelayanan">Pelayanan yang di berikan</label>
                        <select  name="kd_pelayanan" class="form-control @error('kd_pelayanan') is-invalid @enderror" value="{{old('kd_pelayanan')}}" id="kd_pelayanan">
                            <option value="" selected>Pilihan</option>
                            <option value="Pelayanan Pertama" {{(old('kd_pelayanan')=='Pelayanan Pertama')?'selected':''}}>Pelayanan Pertama</option>
                            <option value="Pelayanan ke 2 & 3" {{(old('kd_pelayanan')=='Pelayanan ke 2 & 3')?'selected':''}}>Pelayanan ke 2 & 3</option>
                            <option value="Anak/Bayi dinyatakan Sehat" {{(old('kd_pelayanan')=='Anak/Bayi dinyatakan Sehat')?'selected':''}}>Pelayanan Ke 4+</option>
                            <option value="Anak/Bayi dinyatakan Sehat" {{(old('kd_pelayanan')=='Anak/Bayi dinyatakan Sehat')?'selected':''}}>Anak/Bayi dinyatakan Sehat</option>
                            <option value="Pemberian Inisiasi Menyusui Dini" {{(old('kd_pelayanan')=='Pemberian Inisiasi Menyusui Dini')?'selected':''}}>Pemberian Inisiasi Menyusui Dini</option>
                            <option value="Pemberian Vitamin K1" {{(old('kd_pelayanan')=='Pemberian Vitamin K1')?'selected':''}}>Pemberian Vitamin K1</option>
                            <option value="Hasil Skrining +" {{(old('kd_pelayanan')=='Hasil Skrining +')?'selected':''}}>Hasil Skrining +</option>
                            <option value="Hasil Skrining -" {{(old('kd_pelayanan')=='Hasil Skrining -')?'selected':''}}>Hasil Skrining -</option>
                            <option value="Hasil Tes Konfirmasi +" {{(old('kd_pelayanan')=='Hasil Tes Konfirmasi +')?'selected':''}}>Hasil Tes Konfirmasi +</option>
                            <option value="Hasil Tes Konfirmasi -" {{(old('kd_pelayanan')=='Hasil Tes Konfirmasi -')?'selected':''}}>Hasil Tes Konfirmasi -</option>
                            <option value="Pengobatan Levo- Tiroksin" {{(old('kd_pelayanan')=='Pengobatan Levo- Tiroksin')?'selected':''}}>Pengobatan Levo- Tiroksin</option>
                            <option value="Pelayanan Standar lebih dari 4x kunjungan" {{(old('kd_pelayanan')=='Pelayanan Standar lebih dari 4x kunjungan')?'selected':''}}>Pelayanan Standar lebih dari 4x kunjungan</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 1" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 1')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 1</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 2" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 2')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 2</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 3" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 3')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 3</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 4" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 4')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 4</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 5" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 5')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 5</option>
                            <option value="Pemberian ASI Eksklusif bulan ke 6" {{(old('kd_pelayanan')=='Pemberian ASI Eksklusif bulan ke 6')?'selected':''}}>Pemberian ASI Eksklusif bulan ke 6</option>
                            
                        </select>
                        @error('kd_pelayanan')
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
		          <button type="submit" class="btn btn-primary">Simpan Data Kematian Anak</button>
          </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>
      </div>
</div>
@yield('modalKondisiLahir');
<!-- END Modal KondisiLahir -->

<!-- Modal Meninggal -->
<div class="modal fade modalKematian" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
            <h3>Form Anak/Bayi Meninggal</h3>
          </div>
          <div class="modal-body">
             <form method="post" action="/anak/{{$anak->id}}/addKematian" id="formAnakMeninggal">
                @csrf
                    <div class="form-group">
                        <label for="tgl_kematian">Tanggal Meninggal</label>
                        <input type="date" class="form-control @error('tgl_kematian') is-invalid @enderror" id="tgl_kematian"  name="tgl_kematian" value="{{old('tgl_kematian')}}">
                        @error('tgl_kematian')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                       <label for="tempat">Tempat Meninggal</label>
                       <select  name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{old('tempat')}}" id="tempat">
                            <option value="" selected>Pilihan</option>
                           <option value="Puskesmas/Pustu" {{(old('tempat')=='Puskesmas/Pustu')?'selected':''}}>Puskesmas/Pustu</option>
                           <option value="Polindes" {{(old('tempat')=='Polindes')?'selected':''}}>Polindes</option>
                           <option value="Posyandu" {{(old('tempat')=='Posyandu')?'selected':''}}>Posyandu</option>
                           <option value="Rumah" {{(old('tempat')=='Rumah')?'selected':''}}>Rumah</option>
                           <option value="Unit Pelayanan Swasta" {{(old('tempat')=='Unit Pelayanan Swasta')?'selected':''}}>Unit Pelayanan Swasta</option>
                           <option value="Rumah Sakit" {{(old('tempat')=='Rumah Sakit')?'selected':''}}>Rumah Sakit</option>
                           <option value="Lain-lain" {{(old('tempat')=='Lain-lain')?'selected':''}}>Lain-lain</option>
                       </select>
                        @error('tempat')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="usia_kematian">Usia Meninggal</label>
                        <input type="text" class="form-control @error('usia_kematian') is-invalid @enderror" id="usia_kematian" placeholder="Masukan Usia Kematian" name="usia_kematian" value="{{old('usia_kematian')}}">
                        @error('usia_kematian')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    <div class="form-group" >
                        <label for="penyebab_kematian">Penyebab Meninggal</label>
                        <select  name="penyebab_kematian" class="form-control @error('penyebab_kematian') is-invalid @enderror" value="{{old('penyebab_kematian')}}" id="penyebab_kematian">
                            <option value="" selected>Pilihan</option>
                            <option value="Diare" {{(old('penyebab_kematian')=='Diare')?'selected':''}}>Diare</option>
                            <option value="Pneumonia" {{(old('penyebab_kematian')=='Pneumonia')?'selected':''}}>Pneumonia</option>
                            <option value="Malaria" {{(old('penyebab_kematian')=='Malaria')?'selected':''}}>Malaria</option>
                            <option value="Campak" {{(old('penyebab_kematian')=='Campak')?'selected':''}}>Campak</option>
                            <option value="DBD" {{(old('penyebab_kematian')=='DBD')?'selected':''}}>DBD  </option>
                            <option value="Difteri" {{(old('penyebab_kematian')=='Difteri')?'selected':''}}>Difteri  </option>
                            <option value="Lain-lain" {{(old('penyebab_kematian')=='Lain-lain')?'selected':''}}>Lain-lain  </option>
                        </select>
                        @error('penyebab_kematian')
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
		          <button type="submit" class="btn btn-primary">Simpan Data Kematian Anak</button>
          </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>
      </div>
</div>
@yield('modalMeninggal');
<!-- END Modal Meninggal -->

<!-- Modal Imunisasi -->
<div class="modal fade modalImunisasi" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
            <h3>Form Imunisasi</h3>
          </div>
          <div class="modal-body">
             <form method="post" action="/anak/{{$anak->id}}/addImunisasi" id="formImunisasi">
                @csrf
                    <div class="form-group">
                        <label for="tgl_kunjungan">Tanggal Imunisasi Anak</label>
                        <input type="date" class="form-control @error('tgl_kunjungan') is-invalid @enderror" id="tgl_kunjungan"  name="tgl_kunjungan" value="{{old('tgl_kunjungan')}}">
                        @error('tgl_kunjungan')
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>                    
                    <div class="form-group" >
                       <label for="imunisasi_id">Imunisasi</label>
                       <select  name="imunisasi_id" class="form-control @error('imunisasi_id') is-invalid @enderror" value="{{old('imunisasi_id')}}" id="imunisasi_id">
                           <option value="" selected>Pilihan</option>
                           @foreach($imunisasi as $imunisasi)
                           <option value="{{$imunisasi->id}}" {{(old('imunisasi_id')=='$imunisasi->id')?'selected':''}}>{{$imunisasi->nama_imunisasi}}</option>
                           @endforeach
                       </select>
                        @error('imunisasi_id')
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
<!-- END Modal Imunisasi -->

<!-- Modal Info -->
<div class="modal fade " id="modalInfo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
            <h3>Info Kode Pelayanan dan Kode Kondisi</h3>
          </div>
          <div class="modal-body">
             <div class="text-center">
              <b>
                  <h4>Info Kode Kondisi</h4>
              </b>
          </div>
          <br>
            <div class="row">
                <div class="col-sm-3">
                    <p > N = Berat Badan Naik </p>
                </div>
                <div class="col-sm-3">
                    <p > T = Berat Badan Tetap</p>
                </div>
                <div class="col-sm-3">
                    <p > O = Tidak Ditimbang Bulan Lalu </p>
                </div>
                <div class="col-sm-3">
                    <p > B = Baru Pertama Timbang</p>
                </div>
            </div>
          <br>
            <div class="text-center">
              <b>
                  <h4>Info Kode Pelayanan</h4>
              </b>
          </div>
          <br>
            <div class="row">
                <div class="col-sm-4">
                    <p > D = Pelayanan Pertama</p>
                    <p > D 2x = Pelayanan ke 2 & 3</p>
                    <p > D 4x = Pelayanan Ke 4+</p>
                    <p > * = Anak/Bayi dinyatakan Sehat</p>
                    <p > M = Anak Sakit Menndapatkan Pelayanan MTBS</p>
                </div>
                <div class="col-sm-4">
                    <p > S = Anak Sakit Tdk Menndapatkan Pelayanan MTBS</p>
                    <p > LT = Pengobatan Levo- Tiroksin</p>
                    <p > EID+ISERO+ = Pemeriksaan HIV pada Anak > 18 Bulan</p>
                    <p > ARV = Pengobatan ARV</p>
                    <p > PPK = Pengobatan Profilaksis Kotrimoksazol</p>
                </div>
                <div class="col-sm-4">
                    <p > A = Pemberian Vitamin A</p>
                    <p > IMD* = Pemberian Inisiasi Menyusui Dini</p>
                    <p > Vit K1 = Pemberian Vitamin K1</p>
                    <p > SHK+ = Hasil Skrining Positif</p>
                    <p > SHK- = Hasil Skrining Negatif</p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <p > HK+  = Hasil Tes Konfirmasi Positif</p>
                    <p > HK- = Hasil Tes Konfirmasi Negatif</p>
                    <p > LT  = Pengobatan Levo- Tiroksin</p>
                    <p > PR = Pelayanan Standar lebih dari 4x kunjungan</p>
                </div>
                <div class="col-sm-4">
                    <p > E1 = Pemberian ASI Eksklusif Bln ke 1</p>
                    <p > E2 = Pemberian ASI Eksklusif Bln ke 2</p>
                    <p > E3  = Pemberian ASI Eksklusif Bln ke 3</p>
                </div>
                <div class="col-sm-4">
                    <p > E4 = Pemberian ASI Eksklusif Bln ke 4</p>
                    <p > E5 = Pemberian ASI Eksklusif Bln ke 5</p>
                    <p > E6 = Pemberian ASI Eksklusif Bln ke 6</p>
                </div>
            </div>
           
           
          <div class="modal-footer">
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>
      </div>
</div>
@yield('modalImunisasi');
<!-- END Modal Info -->
