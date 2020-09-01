@extends('layout.main')

@section('title','Kader')

@section('container'.'')


<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid" >
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3">Daftar Kader</h1>
                                
                                <div class="right" style="margin-top:35px; ">
                                    <a href="/kader/create" class="btn btn-primary "><i class="fa fa-user-plus"></i></a> 
                                </div>
                            </div>
                                
                                <div class="panel-body" style="height:850px;">
                                    @if(session('status'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
											<i class="fa fa-check-circle"></i> {{session('status')}}
										</div>
                                    @endif
									@if($errors->any())
                                        <div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
											<i class="fa fa-warning"></i> Data Password Tidak Tersimpan
										</div>
                                    @endif
                                    <div class="table-responsive">
											<table class="table project-table">
												<thead>
													<tr>
														<th>Nama</th>
														<th>Alamat</th>
														<th>No Identitas</th>
														<th>No Telp</th>
														<th>Username</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
                                                @foreach($kader as $kader)
                                                @if($kader->role_id!="petugas")
													<tr>
														<td>{{$kader->nama}}</td>
														<td>{{$kader->alamat}}</td>
														<td>{{$kader->no_identitas}}</td>
														<td>{{$kader->telp}}</td>
														<td><img src="img/foto/{{$kader->image}}" alt="Avatar" class="avatar img-circle">{{$kader->username}}</td>
														<td>
															<div class="btn-group" role="group" aria-label="Basic example">
																<a href="/kader/{{$kader->id}}/edit"class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit Biodata"><i class="fa fa-edit"></i></a>
																<a href=""class="btn btn-success" data-toggle="modal" data-placement="top" title="Edit Password" data-target="#modalUbahUser"><i class="fa fa-lock" value="{{$kader->id}}"></i></a>
																<form action="/kader/{{$kader->id}}" style="display:inline-block;" method="post">
																	@csrf
																	@method('delete')
																	<button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data" onClick="return confirm('Anda Yakin Ingin Merubah Password ?') "><i class="fa fa-trash"></i></button>
																</form>
															</div>
														</td>
                                                    </tr>
													<!-- Modal User -->
													<div class="modal fade" id="modalUbahUser" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-xl">
															<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																	</button>
																<h3>Ubah Password</h3>
															</div>
															<div class="modal-body">
																<form method="post" action="/kader/{{$kader->id}}/password" id="{{$kader->id}}">
																	@csrf
																		<div class="input-group">
																			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
																			<input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" value="{{old('password')}}">
																			@error('password')
																				<div class="invalid-feedback">{{$message}}</div> 
																			@enderror
																		</div>
																		<br>
																		<div class="input-group">
																			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
																			<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror form-control-sm" id="password_confirmation" placeholder="Konfirmasi Password" name="password_confirmation" value="{{old('password_confirmation')}}">
																			@error('password_confirmation')
																				<div class="invalid-feedback">{{$message}}</div> 
																			@enderror
																		</div>
															</div>
															<div class="modal-footer">
																	<button type="submit" class="btn btn-primary" onClick="return confirm('Anda Yakin Ingin Merubah Password ?') ">Ubah Password</button>
															</form>
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
													<!-- END Modal User -->
                                                @endif
                                                @endforeach
												</tbody>
											</table>
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
