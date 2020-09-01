@extends('layout.main')

@section('title','Laporan')

@section('container'.'')
<style> 
#menuReport
 {
    height:145px;
    width:245px;
    font-size: 24px;
    color: white;
}
#menu #menuReport
{
    margin-top:10px;
    margin-left:30px;
}
 </style>
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid" >
                    <div class="col-md-12">
                        <div class="panel" style="min-height:580px;">
                            
                            <div id="menu" style="margin-top:25px; padding:10px;">
                                <a id="menuReport" href="/laporan_ibu" class="btn btn-warning col-md-3 mr-3">
                                    <div style="padding-top: 50px;">
                                        <strong>Laporan Ibu</strong>
                                        <i class="fa fa-book"></i>
                                    </div>
                                </a>
                                <a id="menuReport" style="color: white"  href="/laporan_kb" class="btn btn-info col-md-3 mr-3">
                                    <div style="padding-top: 50px;">
                                        <strong>Laporan KB</strong>
                                        <i class="fa fa-book"></i>
                                    </div>
                                </a>
                                <a id="menuReport"  href="/laporan_anak" class="btn btn-success col-md-3 mr-3">
                                    <div style="padding-top: 50px;">
                                        <strong>Laporan Anak</strong>
                                        <i class="fa fa-book""></i>
                                    </div>
                                </a>
                            </div>
                                
		                    	</div>
		                    </div>
		                    	<!-- END MAIN CONTENT -->
		                 </div>
                     </div>
                 </div>
			        
    

<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('charts/highcharts.js')}}"></script>


@endsection