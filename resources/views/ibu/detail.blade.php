@extends('ibu/modal')
@extends('layout/main')
@extends('layout.include.nav')


@section('title','Detail')

@section('container'.'')
<div class="main" style="min-height:800px;">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h1 class="name" style="margin-top:-20px;">Detail Data Ibu</h1>
					<div class="panel panel-profile" >
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left" >
								<!-- PROFILE DETAIL -->
								<div class="profile-detail" style="margin-top:-22px;">
									<div class="profile-info" style="margin-bottom:10px;">
										<h3 class="heading">{{$ibu->nama_ibu}}</h3>
										<ul class="list-unstyled list-justify">
											<li>NIK Ibu <span>{{$ibu->NIK}}</span></li>
                                            <li>Nama Suami <span>{{$ibu->nama_suami}}</span></li>
                                            <li>Alamat <span>Dusun {{$ibu->dusun->nama_dusun}}</span></li>
                                            <li>Umur <span>{{$ibu->umur}} Tahun</span></li>
                                            <li>Usia Kehamilan <span>{{$ibu->usia_hamil}} Minggu</span></li>
                                            <li>Kehamilan Ke <span>{{$ibu->kehamilan_ke}}</span></li>
                                            <li>Jarak Kehamilan <span>{{$ibu->jrk_hamil}} Tahun</span></li>
                                            <li>Berat Badan Ibu Hamil <span>{{$ibu->bb}} Kg</span></li>
                                            <li>Tinggi Badan Ibu Hamil <span>{{$ibu->td}} Cm</span></li>
                                            <li>Tekanan Darah Ibu Hamil <span>{{$ibu->bb}} mmHG</span></li>
                                            <li>Penanganan Resiko  <span> {{$ibu->p_resiko}}</span></li>
                                            @if($ibu->ket =="")
                                            <li>Tgl Penanganan Resiko   <span>-</span></li>
                                            @else
                                            <li>Tgl Penanganan Resiko   <span>{{$ibu->tgl_p_resiko}}</span></li>
                                            @endif
										</ul>
									</div>
                                    <div class="profile-info" style="margin-left:-23px; margin-top:-20px;">
                                         <div class="panel-heading">
                                              <h3 class="panel-title">Keterangan</h3>
                                          </div>
                                          <div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height: 75px; margin-top:-25px;">
                                                <div class="panel-body" style="overflow: auto; width: auto; height: 75px;">
                                                    @if($ibu->ket =="")
                                                    <p>- </p>
                                                    @else
                                                    <p>{{$ibu->ket}}</p>
                                                    @endif
                                                    </div>
                                                   <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 113px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 61.744px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                            </div>
									</div>
								</div>
								<div class="text-center" style="margin-top:-70px;">
                                    <a href="{{$ibu->id}}/edit" class="btn btn-primary btn-sm">Edit Data</a>
                                    <form action="{{$ibu->id}}" method="post"style="display: inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data Ibu ?') ">Delete Profile</button>
                                    </form>
                                </div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right" style="height:600px">
								
								<!-- TABBED CONTENT -->
								<div class=" heading custom-tabs-line tabs-line-bottom left-aligned">
									<ul class="nav" role="tablist" style="margin-top:-15px; margin-left:-15px; margin-bottom:-11px;"  id="myTab">
                                        <li class="" role="presentation" >
                                            <a class="nav-link" data-toggle="tab" href="#kunjungan" role="tab">
                                                 Kunjungan Ibu Hamil
                                            </a>
                                        </li>
                                        <li role="presentation" >
                                            <a class="nav-link" data-toggle="tab" href="#persalinan" role="tab">
                                                Persalinan
                                            </a>
                                        </li>
                                        <li role="presentation" >
                                            <a class="nav-link" data-toggle="tab" href="#menyusui" role="tab">
                                                Ibu Menyusui
                                            </a>
                                        </li>
									</ul>
                                </div>
								<div class="tab-content">
									<div class="tab-pane fade in " role="tabpanel" id="kunjungan" style="padding:0;">
                                        <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#exampleModal">
                                              <i class="fa fa-plus"></i>
                                          </button>
                                              @if($ibu->kunjunganibu->count()>0)
                                              <div class="table-responsive" >
                                                            <table class="table project-table" style="font-size:12px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Kategori Usia Hamil</th>
                                                                        <th>Tanggal Kunjungan</th>
                                                                        <th>Keterangan</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($ibu->kunjunganibu as $ki)
                                                                    <tr>
                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>
                                                                            <a href="#" class="usia_hamil" data-type="select" data-pk="{{$ki->id}}" data-url="/api/ibu/{{$ibu->id}}/usia" data-title="Masukan Tanggal ">
                                                                                {{$ki->usia_hamil}}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="tgl_kunjungan" data-type="date" data-pk="{{$ki->id}}" data-url="/api/ibu/{{$ibu->id}}/tanggal" data-title="Masukan Tanggal ">
                                                                                {{$ki->tgl_kunjungan}}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="ket" data-type="text" data-pk="{{$ki->id}}" data-url="/api/ibu/{{$ibu->id}}/ket" data-title="Masukan Keterangan">
                                                                                {{$ki->ket}}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <form action="{{$ibu->id}}/{{$ki->id}}" method="post" >
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit" class="btn btn-danger btn-sm lnr lnr-trash"  onClick="return confirm('Hapus Data Ibu ?') "></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                             @if($ibu->kunjunganibu->count() >=4)
                                                            {!!$ibu->paginate(4,['*'],'kunjunganibu')!!}
                                                            @endif
                                              </div>
                                              @else
                                              <h4 class="name text-center" >Data Kunjungan Kosong</h4>
                                              @endif
                                              @section('modalKunjungan')
                                              @endsection
									</div>
                                    
                                    <div class="tab-pane fade" role="tabpanel" id="persalinan" style="padding:0;">
                                    <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalPersalinan">
                                       <i class="fa fa-plus"></i>
                                    </button>
										<div class="table-responsive">
                                        @if($ibu->persalinan->count()>0)
                                            <table class="table project-table" style="font-size:12px;">
												 <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Tanggal Persalinan</th>
                                                          <th>Tenaga Penolong</th>
                                                          <th>Jenis Kelahiran</th>
                                                          <th>Aksi</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  @foreach($ibu->persalinan->sortByDesc('id') as $pe)
                                                      <tr>
                                                          <td>{{$loop->iteration}}</td>
                                                          <td>
                                                              <a href="#" class="tgl_persalinan" data-type="date" data-pk="{{$pe->id}}" data-url="/api/ibu/{{$ibu->id}}/tanggalPersalinan" data-title="Masukan Tanggal ">
                                                                  {{$pe->tgl_persalinan}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="tng_penolong" data-type="select" data-pk="{{$pe->id}}" data-url="/api/ibu/{{$ibu->id}}/tngPenolong" data-title="Masukan Tenaga Penolong ">
                                                                  {{$pe->tng_penolong}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="jenis_kelahiran" data-type="select" data-pk="{{$pe->id}}" data-url="/api/ibu/{{$ibu->id}}/jenisKelahiran" data-title="Masukan Jenis Kelahiran">
                                                                  {{$pe->jenis_kelahiran}}
                                                              </a>
                                                              Kg
                                                          </td>
                                                          <td>
                                                              <form action="{{$ibu->id}}/{{$pe->id}}/persalinan" method="post" class="d-inline">
                                                                  @csrf
                                                                  <button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data Ibu ?') "></button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                  @endforeach
                                                  </tbody>
											</table>
                                        @else
					                    <h4 class="name text-center" >Data Persalinan Kosong</h4>
                                        @endif
										</div>
                                         @section('modalPersalinan')
                                         @endsection
									</div>

                                    <div class="tab-pane fade" role="tabpanel" id="menyusui" style="padding:0;">
                                     <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalMenyusui">
                                         <i class="fa fa-plus"></i>
                                     </button>
										<div class="table-responsive">
                                        @if($ibu->ibumenyusui->count()>0)
                                            <table class="table project-table" style="font-size:13px;">
												 <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Kunjungan</th>
                                                        <th>Keterangan</th>
                                                        <th>Periode Nifas</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($ibu->ibumenyusui as $me)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>
                                                            <a href="#" class="tgl_nifas" data-type="date" data-pk="{{$me->id}}" data-url="/api/ibu/{{$ibu->id}}/tanggalNifas" data-title="Masukan Tanggal ">
                                                                {{$me->tgl_nifas}}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="keterangan" data-type="text" data-pk="{{$me->id}}" data-url="/api/ibu/{{$ibu->id}}/ketNifas" data-title="Masukan Keterangan Nifas ">
                                                                {{$me->ket}}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="periode_nifas" data-type="select" data-pk="{{$me->id}}" data-url="/api/ibu/{{$ibu->id}}/periodeNifas" data-title="Masukan Jenis Kelahiran">
                                                                {{$me->periode_nifas}}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <form action="{{$ibu->id}}/{{$me->id}}/menyusui" method="post" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data Ibu ?') "></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
											</table>
                                             @if($ibu->ibumenyusui->count()>=4)
                                            {!!$ibu->paginate(4,['*'],'ibumenyusui')!!}
                                            @endif

                                        @else
					                    <h4 class="name text-center" >Data Ibu Menyusui Kosong</h4>
                                        @endif
										</div>
                                        @section('modalNifas')
                                        @endsection
									</div>
								</div>
								<!-- END TABBED CONTENT -->
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>

@endsection
@section('footer')
<script src="{{asset('js/data/tab.js')}}"></script>
<script>
	$(document).ready(function() {
        
        //edit modal
       $("#kunjunganibu").validate({
            rules: {
                tgl_kunjungan: "required",
                usia_hamil: "required",
                ket: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                tgl_kunjungan: "Data Tidak Boleh Kosong",
                usia_hamil: "Data Belum dipilih",
                ket: {
                    required: "Data Tidak Boleh Kosong",
                    minlength: "Data Minimal 8 karakter"
                }
            }
        });
       $("#persalinanibu").validate({
            rules: {
                tgl_persalinan: "required",
                tng_penolong: "required",
                jenis_kelahiran: "required"
                
            },
            messages: {
                tgl_persalinan: "Data Tidak Boleh Kosong",
                tng_penolong: "Data Belum dipilih",
                jenis_kelahiran: "Data Belum dipilih"
                
            }
        });
       $("#ibumenyusui").validate({
            rules: {
                tgl_nifas: "required",
                periode_nifas: "required",
                ket: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                tgl_nifas: "Data Tidak Boleh Kosong",
                periode_nifas: "Data Belum dipilih",
                ket: {
                    required: "Data Tidak Boleh Kosong",
                    minlength: "Data Minimal 8 karakter"
                }
            }
        });
        //edit live
        $('.usia_hamil').editable({
             source: [
                   {value: '0-12 minggu', text: '0-12 minggu'},
                   {value: '13-24 minggu', text: '13-24 minggu'},
                   {value: '25-27 minggu', text: '25-27 minggu'},
                   {value: '28 minggu', text: '28 minggu'},
                   {value: '24-<40 minggu', text: '24-<40 minggu'}
                ],
                validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.tgl_kunjungan').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.ket').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.tgl_persalinan').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.tng_penolong').editable({
             source: [
                   {value: 'Tenaga Kesehatan', text: 'Tenaga Kesehatan'},
                   {value: 'Dukun Terlatih', text: 'Dukun Terlatih'},
                   {value: 'Dukun Tak Terlatih', text: 'Dukun Tak Terlatih'}
                ],
                validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.jenis_kelahiran').editable({
             source: [
                   {value: 'Lahir Mati', text: 'Lahir Mati'},
                   {value: 'Lahir Hidup -2.5', text: 'Lahir Hidup -2.5'},
                   {value: 'Lahir Hidup +2.5', text: 'Lahir Hidup +2.5'}
                ],
               validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             } 
         }); 
        
        $('.tgl_nifas').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
        $('.keterangan').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.periode_nifas').editable({
             source: [
                   {value: '6 jam-3 hari', text: '6 jam-3 hari'},
                   {value: '8-12 hari', text: '8-12 hari'},
                   {value: '36-42 hari', text: '36-42 hari'},
                   {value: '42-2 tahun', text: '42-2 tahun'}
                ],
            validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
     })
</script>
@stop