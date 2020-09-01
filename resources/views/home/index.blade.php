@extends('home.modal')
@extends('layout.main')

@section('title','Dokumentasi')

@section('container'.'')
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3 d-block">Data Dokumentasi</h1>
                           		    <div class="right" style="margin-top:42px; ">
                           		     	<a href="/doc/create" class="btn btn-primary btn-md fa fa-plus-circle"> Tambah Data</a> 
                           		    </div>
									<div class="btn-group" role="group" aria-label="Basic example">
										<a href="doc/D0004/doc" class="btn btn-primary btn-md fa fa-pencil">
											 About
										</a>
										<a href="doc/D0000/doc" class="btn btn-primary btn-md fa fa-pencil">
											 Ibu
										</a>
										<a href="doc/D0001/doc" class="btn btn-primary btn-md fa fa-pencil">
											 Anak
										</a>
										<a href="doc/D0002/doc" class="btn btn-primary btn-md fa fa-pencil">
											 KB
										</a>
									</div>
                           		 </div>
                                    <div class="panel-body">
										@if(session('status'))
                                    	    	<div class="alert alert-success alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
													<i class="fa fa-check-circle"></i> {{session('status')}}
												</div>
                                    	     </div>
                                    	@endif
										

										@foreach($doc as $image)
										<div class="col-md-4">
											<div class="panel panel-default">
												<div class="panel-body text-center" style="height:331px;">
													<a href="#{{$image->id}}" data-toggle="modal">
														<img src="img/doc/{{$image->img}}" alt="" class="img-thumbnail" style="widht:400px; height:210px;">
													</a>
													<div>
														<h4><b>{{$image->judul}}</b></h4>
													</div>
													<div class="text-center">
														<div class="float-left">
														 	<h5>
																Diunggah pada {{$image->created_at->format('d-m-Y')}}
															 </h5>
																<a href="doc/{{$image->id}}/edit" class="btn btn-primary btn-xs lnr lnr-pencil"></a>
																<form action="doc/{{$image->id}}" method="post"style="display: inline">
																	@csrf
																	@method('delete')
																	<button type="submit" class="btn btn-danger btn-xs lnr lnr-trash" onClick="return confirm('Hapus Data KB ?') "></button>
																</form>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- modal -->
										<div class="modal fade " id="{{$image->id}}">
   										   <div class="modal-dialog modal-md">
   										     <div class="modal-content">
   										       <div class="modal-body">
   										         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												</button>
												<div class="text-center">
													<img src="img/doc/{{$image->img}}" alt="" class="img-thumbnail" style="widht:45%;">
												</div>
   										       </div>
   										     </div>
   										   </div>
   										 </div>
										@endforeach
									</div>
									<div class="panel-footer" style="display:block;">
										{{$doc->links()}}
									</div>
		                    	</div>
		                    </div>
							
		                    	<!-- END MAIN CONTENT -->
		                 </div>
                     </div>
                 </div>
			        
    

<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('.view_data').click(function(){
			$('.ModalDoc').modal('show');
		});
	});
</script>
@endsection
