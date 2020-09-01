@extends('layout.main')

@section('title','Daftar Anak')

@section('container'.'')
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid" >
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3">Daftar Anak</h1>
                                 <div class="right">
                                    <a href="/anak/create" class="btn btn-primary btn-md  fa fa-plus" style="margin-bottom:-45px;"></a> 
                                </div>
                            </div>
                                
                                <div class="panel-body" style="height:850px;">
                                <form class="form-inline my-2 my-lg-2" style="padding:10px; margin-bottom:8px; margin-top:-14px;" method="post" action="/anak">
		                    	@method('get')
									<div class="input-group">
										<input type="search" value="{{$key}}" class="form-control" placeholder="Masukan Nama Anak/Bayi"  name="search">
										<span class="input-group-btn"><button type="submit" class="btn btn-primary">Cari</button></span>
									</div>
		                    	</form>
                                    @if(session('status'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
											<i class="fa fa-check-circle"></i> {{session('status')}}
										</div>
                                    @endif
                                    <ul class="list-group">
                                        @foreach($anak as $key => $ank)
                                            <a href="/anak/{{$ank->id}}" class="">
                                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{($anak->currentpage()-1) * $anak->perpage() + $key + 1 }}. {{$ank->nama_anak}}
                                                 <span class="mr-2 right">Dibuat Pada Tanggal {{$ank->created_at->format('d-m-Y')}}</span>
                                             </li>
                                            </a>
                                         @endforeach
                                    </ul>
                                     <div class="panel-footer">
											{{$anak->links()}}
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