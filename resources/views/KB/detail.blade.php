@extends('KB/modal')
@extends('layout/main')
@extends('layout.include.nav')


@section('title','Detail')

@section('container'.'')
<div class="main" style="min-height:800px;">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h1 class="name" >Detail Peserta KB</h1>
					<div class="panel panel-profile" >
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left" >
								<!-- PROFILE DETAIL -->
								<div class="profile-detail" >
									<div class="profile-info" >
										<h3 class="heading">{{$kb->nama_ibu}}</h3>
										<ul class="list-unstyled list-justify">
                                            <li>Nama Suami <span>{{$kb->nama_suami}}</span></li>
                                            <li>Alamat <span>Dusun {{$kb->dusun->nama_dusun}}</span></li>
                                            <li>Umur <span>{{$kb->umur}} Tahun</span></li>
                                            <li>Jumlah Anak <span>{{$kb->jmlh_anak}} Minggu</span></li>
                                            @if($kb->riwayat_penyakit!="-")
                                            <li>Riwayat Penyakit <span>{{$kb->riwayat_penyakit}}</span></li>
                                            @else
                                            <li>Riwayat Penyakit <span>Tidak Ada</span></li>
                                            @endif
                                            @if($kb->gakin>0)
                                            <li>Gakin <span>Ada</span></li>
                                            @else
                                            <li>Gakin <span>Tidak Ada</span></li>
                                            @endif
                                            @if($kb->faktor_resiko>0)
                                            <li>4T <span>Ada</span></li>
                                            @else
                                            <li>4T <span>Tidak Ada</span></li>
                                            @endif
                                            @if($kb->pasca_bersalin!="")
                                            <li>Pasca Bersalin <span>{{$kb->pasca_bersalin}}</span></li>
                                            @else
                                            <li>Pasca Bersalin <span>Tidak Ada</span></li>
                                            @endif
										</ul>
									</div>
                                    <div class="profile-info" style="margin-left:-23px; margin-top:-34px;">
                                         <div class="panel-heading" style="margin-bottom:-9px;"> 
                                              <h3 class="panel-title">Keterangan</h3>
                                          </div>
                                          <div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height: 75px;">
                                                <div class="panel-body" style="overflow: auto; width: auto; height: 75px; margin-top:-15px;">
                                                    @if($kb->ket =="")
                                                    <p>- </p>
                                                    @else
                                                    <p>{{$kb->ket}}</p>
                                                    @endif
                                                    </div>
                                                   <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 113px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 61.744px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                            </div>
									</div>
									<div class="text-center" style="margin-top:-30px;">
                                            <a href="{{$kb->id}}/edit" class="btn btn-primary btn-sm">Edit Data</a>
                                            <form action="{{$kb->id}}" method="post"style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data Ibu ?') ">Delete Profile</button>
                                            </form>
                                        </div>
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right" style="height:600px">
								
								<!-- TABBED CONTENT -->
								<div class=" heading custom-tabs-line tabs-line-bottom left-aligned">
									<ul class="nav" role="tablist" style="margin-top:-15px; margin-left:-15px; margin-bottom:-11px;" id="myTab">
                                        <li class="" >
                                            <a class="nav-link" data-toggle="tab" href="#kunjungan">
                                                 Kunjungan Peserta KB
                                            </a>
                                        </li>
									</ul>
                                </div>
								<div class="tab-content">
									<div class="tab-pane fade in " id="kunjungan" style="padding:0;">
                                        <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalKunjunganKB">
                                              <i class="fa fa-plus"></i>
                                          </button>
                                              @if($kb->kunjungankb->count()>0)
                                              <div class="table-responsive" >
                                                            <table class="table project-table" style="font-size:12px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Tanggal Kunjungan</th>
                                                                        <th>Kategori Peserta</th>
                                                                        <th>Penggunaan Jenis KB</th>
                                                                        <th>Keterangan</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($kb->kunjungankb as $KB)
                                                                    <tr>
                                                                            <td>{{$loop->iteration}}</td>
                                                                        <td>
                                                                            <a href="#" class="tgl_kunjungan" data-type="date" data-pk="{{$KB->id}}" data-url="/api/KB/{{$KB->id}}/tanggalKB" data-title="Masukan Tanggal ">
                                                                                {{$KB->tgl_kunjungan}}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="kategori_peserta" data-type="select" data-pk="{{$KB->id}}" data-url="/api/KB/{{$KB->id}}/kategoriKB" data-title="Kategori Peserta KB">
                                                                                {{$KB->kategori_peserta}}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="jenis_kb" data-type="select" data-pk="{{$KB->id}}" data-url="/api/KB/{{$KB->id}}/jenisKB" data-title="Jenis Alat KB ">
                                                                                {{$KB->jenis_kb}}
                                                                            </a>
                                                                        </td>
                                                                        @if($KB->ket!="")
                                                                        <td>
                                                                            <a href="#" class="ket" data-type="text" data-pk="{{$KB->id}}" data-url="/api/KB/{{$KB->id}}/ketKB" data-title="Keterangan ">
                                                                                {{$KB->ket}}
                                                                            </a>
                                                                        </td>
                                                                        @else
                                                                        <td>
                                                                            <a href="#" class="ket" data-type="text" data-pk="{{$KB->id}}" data-url="/api/KB/{{$KB->id}}/ketKB" data-title="Keterangan ">
                                                                                Tidak Ada
                                                                            </a>
                                                                        </td>
                                                                        @endif
                                                                        <td>
                                                                            <a href="KB/{{$kb->id}}/edit" class="btn btn-primary btn-sm lnr lnr-pencil"></a>
                                                                            <form action="/KB/{{$kb->id}}/{{$KB->id}}" method="post"style="display: inline">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data KB ?') "></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                             @if($kb->kunjungankb->count() >=4)
                                                            {!!$kb->paginate(6,['*'],'kunjungankb')!!}
                                                            @endif
                                              </div>
                                              @else
                                              <h4 class="name text-center" >Data Kunjungan Kosong</h4>
                                              @endif
                                              @section('modal')
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
	$(document).ready(function(){
		
        // validation modal
        $("#kunjungankb").validate({
            rules: {
                tgl_kunjungan: "required",
                kategori_peserta: "required",
                jenis_kb: "required"
                
            },
            messages: {
                tgl_kunjungan: "Data Tidak Boleh Kosong",
                kategori_peserta: "Data Belum dipilih",
                jenis_kb: "Data Belum dipilih"
            }
        });
        // edit live
		$('.tgl_kunjungan').editable({
			validate: function(value){
				if($.trim(value)==''){
					return 'Data Tidak Boleh Kosong'
				}
			}
		});

		$('.kategori_peserta').editable({
             source: [
                   {value: 'Peserta Baru', text: 'Peserta Baru'},
                   {value: 'Peserta Lama', text: 'Peserta Lama'},
                   {value: 'DO', text: 'DO (Drop Out)'}
                ],
                validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });

		 $('.jenis_kb').editable({
             source: [
                   {value: 'IUD', text: 'IUD'},
                   {value: 'MOW', text: 'MOW'},
                   {value: 'MOP', text: 'MOP'},
                   {value: 'Implan', text: 'Implan'},
                   {value: 'Suntik', text: 'Suntik'},
                   {value: 'Pil KB', text: 'Pil KB'},
                   {value: 'Kondom', text: 'Kondom'},
                   {value: 'Obat Vag', text: 'Obat Vag'},
                   {value: 'Lainnya', text: 'Lainnya'}
                ],
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

	});
</script>
@stop