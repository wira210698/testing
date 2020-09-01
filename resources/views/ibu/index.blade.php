@extends('layout.main')

@section('title','Daftar Ibu')

@section('container'.'')
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid" >
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3">Daftar Ibu</h1>
                                
                                
                                <div class="right">
                                    <a href="/ibu/create" class="btn btn-primary btn-md  fa fa-plus" style="margin-bottom:-45px;"></a> 
                                </div>
                            </div>
                                
                                <div class="panel-body" style="height:650px;">
                                <form class="form-inline my-2 my-lg-2" style="padding:10px; margin-bottom:8px; margin-top:-14px;" method="post" action="/ibu">
		                    	@method('get')
									<div class="input-group">
										<input type="search" value="{{$key}}" class="form-control" placeholder="Masukan Nama Ibu"  name="search">
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
                                        @foreach($ibu as $key => $ib)
                                            <a href="/ibu/{{$ib->id}}" class="">
                                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{($ibu->currentpage()-1) * $ibu->perpage() + $key + 1 }}. {{$ib->nama_ibu}}
                                                 <span class="mr-2 right">Dibuat Pada Tanggal {{$ib->created_at->format('d-m-Y')}}</span>
                                             </li>
                                            </a>
                                         @endforeach
                                    </ul>
                                    <div class="panel-footer">
											{{$ibu->links()}}
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