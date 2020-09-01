@extends('layout.main')
@extends('imunisasi.modal')

@section('title','Data Imunisasi')

@section('container'.'')
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3 d-block">Daftar Imunisasi</h1>
                            </div> 
                                    <div class="panel-body">
											@if(session('status'))
                                    	    	<div class="alert alert-success alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
													<i class="fa fa-check-circle"></i> {{session('status')}}
												</div>
                                    	     </div>
                                    	@endif
										<div class="custom-tabs-line tabs-line-bottom left-aligned">
                                    		<ul class="nav" role="tablist">
                                    		    <li class="active">
                                    		        <a class="nav-link" data-toggle="tab" href="#jenisImunisasi">
                                    		           Jenis Imunisasi
                                    		        </a>
                                    		    </li>
                                    		    <li>
                                    		        <a class="nav-link" data-toggle="tab" href="#anakImunisasi">
                                    		           Imunisasi Anak
                                    		        </a>
                                    		    </li>
											</ul>
										</div>
										

										<div class="tab-content">
                                    		<div class="tab-pane fade in active" id="jenisImunisasi">
                                    		 	<button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalImunisasi">
                                        			 Tambah Data Imunisasi
                                     			</button>
                                        		 @section('modalImunisasi')
                                        		@endsection
												<div class="table-responsive">
													<table class="table table-bordered text-center" style="font-size:13px;">
														<thead>
															<tr>
																<th class="text-center">No</th>
																<th class="text-center">Nama Imunisasi</th>
																<th class="text-center">Keterangan</th>
																<th class="text-center">Aksi</th>
															</tr>
														</thead>
														<tbody>
														@foreach($imunisasi as $i)
															<tr>
																<td>{{$loop->iteration}}</td>
																<td>
																	<a href="#" class="nama_imunisasi" data-type="text" data-pk="{{$i->id}}" data-url="/api/imunisasi/{{$i->id}}/namaImunisasi" data-title="Masukan Nama Imunisasi ">
																		{{$i->nama_imunisasi}}
																	</a>
																</td>
																<td>
																	<a href="#" class="ket" data-type="text" data-pk="{{$i->id}}" data-url="/api/imunisasi/{{$i->id}}/keteranganImunisasi" data-title="Masukan Keterangan Imunisasi ">
																		{{$i->ket}}
																	</a>
																</td>
																<td>
																	<form action="imunisasi/{{$i->id}}" method="post"style="display: inline">
																		@csrf
																		@method('delete')
																		<button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data imunisasi ?') "></button>
																	</form>
																</td>
															
															</tr>
														@endforeach
														</tbody>
													</table>
													{{$imunisasi->links()}}
												</div>
                                    		</div>
                                    		<div class="tab-pane fade in active" id="anakImunisasi">
												<a href="/anak" class="btn btn-primary">Tambah Imunisai Anak</a>
												<div class="table-responsive">
													<table class="table table-bordered text-center" style="font-size:13px;">
														<thead>
															<tr>
																<th class="text-center">No</th>
																<th class="text-center">Nama Anak</th>
																<th class="text-center">Alamat</th>
																<th class="text-center">Tgl Kunjungan</th>
																<th class="text-center">Jenis Imunisasi</th>
																<th class="text-center">Aksi</th>
															</tr>
														</thead>
														<tbody>
														@foreach($anak_imunisasi as $ank_imunisasi)
															<tr>
																<td>{{$loop->iteration}}</td>
																<td>
																	<a href="#" class="nama_imunisasi" data-type="text" data-pk="{{$ank_imunisasi->id}}" data-url="/api/imunisasi/{{$ank_imunisasi->id}}/namaImunisasi" data-title="Masukan Nama Imunisasi ">
																		{{$ank_imunisasi->nama_anak}}
																	</a>
																</td>
																<td>
																	<a href="#" class="nama_imunisasi" data-type="text" data-pk="{{$ank_imunisasi->id}}" data-url="/api/imunisasi/{{$ank_imunisasi->id}}/namaImunisasi" data-title="Masukan Nama Imunisasi ">
																		{{$ank_imunisasi->nama_dusun}}
																	</a>
																</td>
																<td>
																	<a href="#" class="ket" data-type="text" data-pk="{{$ank_imunisasi->id}}" data-url="/api/imunisasi/{{$ank_imunisasi->id}}/keteranganImunisasi" data-title="Masukan Keterangan Imunisasi ">
																		{{$ank_imunisasi->tgl_kunjungan}}
																	</a>
																</td>
																<td>
																	<a href="#" class="ket" data-type="text" data-pk="{{$ank_imunisasi->id}}" data-url="/api/imunisasi/{{$ank_imunisasi->id}}/keteranganImunisasi" data-title="Masukan Keterangan Imunisasi ">
																		{{$ank_imunisasi->nama_imunisasi}}
																	</a>
																</td>
																<td>
																	<form action="imunisasi/{{$ank_imunisasi->id}}" method="post"style="display: inline">
																		@csrf
																		@method('delete')
																		<button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data imunisasi ?') "></button>
																	</form>
																</td>
															
															</tr>
														@endforeach
														</tbody>
													</table>
													{{$anak_imunisasi->links()}}
												</div>
											</div>
											
										</div>
										
									</div>
		                    	</div>
		                    </div>
		                    	<!-- END MAIN CONTENT -->
		                 </div>
                     </div>
                 </div>
			        
    

<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

@endsection
@section('footer')
<script>
	$(document).ready(function(){
		
		 $('.nama_imunisasi').editable({
			 validate: function(value){
				 if($.trim(value)==''){
					 return 'Data Imunisasi Kosong'
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