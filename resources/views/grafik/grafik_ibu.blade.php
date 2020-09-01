@extends('layout.main')

@section('title','Grafik')

@section('container'.'')

<div class="modal fade modalCari" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header" style="height:50px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3 style="margin-top:0;">Pencarian Grafik</h3>
          </div>
          <div class="modal-body">
            <form class="form-inline my-2 my-lg-2" style="padding:10px;  margin-top:8px;" method="post" action="/grafik_ibu">
             @method('get')
                 <div class="form-group" >
                     <label for="bulan">Bulan</label>
                     <select name="bulan" id="bulan" class="form-control" style="margin-left:5px;margin-right:5px;">
                             <option value="01">Januari</option>
                             <option value="02">Februari</option>
                             <option value="03">Maret</option>
                             <option value="04">April</option>
                             <option value="05">Mei</option>
                             <option value="06">Juni</option>
                             <option value="07">Juli</option>
                             <option value="08">Agustus</option>
                             <option value="09">Sebtember</option>
                             <option value="10">Oktober</option>
                             <option value="11">November</option>
                             <option value="12">Desember</option>
                     </select>
                 <label for="periode">Tahun</label>
                 <select name="tahun" id="dateYear" class="form-control" style="margin-left:5px;margin-right:5px;"></select>
                 </div>
          </div>
          <div class="modal-footer">
		          <button type="submit" class="btn btn-primary">Cari Grafik</button>
            </form>
		          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </div>

      </div>
    </div>
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid" >
            <div class="col-md-12">
                <div class="panel panel-headline">
						<div class="heading" style="margin-left:25px;">
                        <button class="btn btn-primary " type="buttom" style="float:right; margin-top:0; margin-right:15px; z-index:999;" data-toggle="modal" data-target=".modalCari"><i class="fa fa-search"></i></button>
							<h3 class="heading">Grafik Pelayanan Ibu</h3>
							<p class="heading">Bulan : {{$keterangan_grafik}}</p>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<div class="metric">
										<span class="icon"><i class="fa fa-female"></i></span>
										<p>
											<span class="number">{{$jmlhKunjunganBlnini}}</span>
											<span class="title" style="padding:5px;">Jumlah Pelayanan Ibu Hamil Bulan ini</span>
										</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="metric">
										<span class="icon"><i class="fa fa-shopping-bag"></i></span>
										<p>
											<span class="number">{{$jmlhPersalinanBlnini}}</span>
											<span class="title" style="padding:5px;">Jumlah Pelayanan Persalinan Ibu Bulan Ini</span>
										</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="metric">
										<span class="icon"><i class="fa fa-eye"></i></span>
										<p>
											<span class="number">{{$jmlhMenyusuiBlnini}}</span>
											<span class="title" style="padding:5px;">Jumlah Pelayanan Ibu Menyusui Bulan Ini</span>
										</p>
									</div>
								</div>
								<!-- <div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">35%</span>
											<span class="title">Conversions</span>
										</p>
									</div>
								</div>
							</div> -->
							<div class="row">
								<div class="col-md-12" id="charts_kunjungan_ibu">
                                    
                                </div>
							</div>
                            <br>
							<div class="row">
								<div class="col-md-12" id="charts_melahirkan">
                                    
                                </div>
							</div>
                            <br>
							<div class="row">
								<div class="col-md-12" id="charts_menyusui">
                                    
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
<script src="{{asset('charts/highcharts.js')}}"></script>
<script>
    var min = 2019,
    max = new Date().getFullYear(),
    select = document.getElementById('dateYear');

    for (var i= min; i<=max; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML =i;
        select.appendChild(opt);

    }
 </script>
<script>
    
    Highcharts.chart('charts_kunjungan_ibu', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Kunjungan Ibu'
        },
        subtitle: {
            text: 'Bulan: '+{!! json_encode($keterangan_grafik)!!}
        },
        xAxis: {
            categories: {!! json_encode($kategoriK)!!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Kunjungan (orang)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} orang</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Bulan lalu',
            data:{!!json_encode($data_K_BL)!!}

        }, {
            name: 'Bulan ini',
            data: {!!json_encode($data_K_BI)!!}

        }]
    });
    Highcharts.chart('charts_melahirkan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Ibu Bersalin'
        },
        subtitle: {
            text: 'Bulan: '+{!! json_encode($keterangan_grafik)!!}
        },
        xAxis: {
            categories: {!! json_encode($kategoriP)!!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Kunjungan (orang)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} orang</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Bulan lalu',
            data:{!!json_encode($data_P_BL)!!}

        }, {
            name: 'Bulan ini',
            data: {!!json_encode($data_P_BI)!!}

        }]
    });
    Highcharts.chart('charts_menyusui', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Ibu Menyusui'
        },
        subtitle: {
            text: 'Bulan: '+{!! json_encode($keterangan_grafik)!!}
        },
        xAxis: {
            categories: {!! json_encode($kategoriM)!!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Kunjungan (orang)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} orang</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Bulan lalu',
            data:{!!json_encode($data_M_BL)!!}

        }, {
            name: 'Bulan ini',
            data: {!!json_encode($data_M_BI)!!}

        }]
    });
</script>

@endsection