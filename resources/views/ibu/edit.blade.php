@extends('layout/main')
@extends('layout.include.nav')

@section('title','Edit data')

@section('container'.'') 
        <h2 class="modal-title" id="exampleModalLabel">Form Edit Data</h2>
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Form Edit Data Ibu</h3>
									<p class="panel-subtitle">Pendataan Ibu Hamil</p>
								</div>
								<div class="panel-body">
                                        <form method="post" action="/ibu/{{$ibu->id}}">
                                        @csrf
                                        @method('patch')
                                            <div class="row">
                                                <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nama">NIK</label>
                                                        <input type="number" class="form-control @error('NIK') is-invalid @enderror form-control-sm" id="NIK" placeholder="NIK" name="NIK" value="{{$ibu->NIK}}">
                                                        @error('NIK')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-8 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nama_ibu">Nama Ibu</label>
                                                        <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror form-control-sm" id="nama_ibu" placeholder="Nama Ibu" name="nama_ibu" value="{{$ibu->nama_ibu}}">
                                                        @error('nama_ibu')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>      
                                                </div>                        
                                            </div>
                                            <div class="row">
                                                <div class="col-8 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="nama_suami">Nama Suami</label>
                                                            <input type="text" class="form-control @error('nama_suami') is-invalid @enderror form-control-sm " id="nama_suami" placeholder="Nama Suami" name="nama_suami" value="{{$ibu->nama_suami}}">
                                                            @error('nama_suami')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div> 
                                                    <div class="col-8 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="dusun_id">Alamat</label>
                                                                <select  name="dusun_id" class="form-control" value="{{$ibu->dusun_id}}">
                                                                    <option value="" >Pilihan</option>
                                                                    @foreach($dusun as $dusun)
                                                                    <option value="{{$dusun->id}}" {{($ibu->dusun_id==$dusun->id)?'selected':''}}>Dusun {{$dusun->nama_dusun}}</option>
                                                                    @endforeach
                                                                </select>
                                                                  @error('dusun_id')
                                                                        <div class="invalid-feedback">{{$message}}</div> 
                                                                    @enderror
                                                        </div>      
                                                </div> 

                                            </div>
                                            <div class="row">
                                                <div class="col-8 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="umur">Umur</label>
                                                            <input type="number" class="form-control @error('umur') is-invalid @enderror form-control-sm  " id="umur" placeholder="Tahun" name="umur" value="{{$ibu->umur}}">
                                                            @error('umur')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div>  
                                                <div class="col-8 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="usia_hamil">Usia Kehamilan</label>
                                                            <input type="number" class="form-control @error('usia_hamil') is-invalid @enderror form-control-sm " id="usia_hamil" placeholder="Minggu" name="usia_hamil" value="{{$ibu->usia_hamil}}">
                                                            @error('usia_hamil')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div> 
                                                <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="kehamilan_ke">Kehamilan Ke-</label>
                                                        <input type="number" class="form-control @error('kehamilan_ke') is-invalid @enderror form-control-sm " id="kehamilan_ke" placeholder="Tahun" name="kehamilan_ke" value="{{$ibu->kehamilan_ke}}">
                                                        @error('kehamilan_ke')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                                </div>                                                 
                                            </div>
                                            <div class="row">
                                                <div class="col-8 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="jrk_hamil">Jarak Kehamilan</label>
                                                            <input type="number" class="form-control @error('jrk_hamil') is-invalid @enderror form-control-sm " id="jrk_hamil" placeholder="Minggu" name="jrk_hamil" value="{{$ibu->jrk_hamil}}">
                                                            @error('jrk_hamil')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div>  
                                                <div class="col-8 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="bb">Berat Badan Ibu Hamil</label>
                                                            <input type="number" class="form-control @error('bb') is-invalid @enderror form-control-sm " id="bb" placeholder="Kg " name="bb" value="{{$ibu->bb}}">
                                                            @error('bb')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div>
                                                <div class="col-8 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="tb">Tinggi Badan Ibu Hamil</label>
                                                        <input type="number" class="form-control @error('tb') is-invalid @enderror form-control-sm" id="tb" placeholder="Masukan Tinggi Badan Ibu Hamil" name="tb" value="{{$ibu->tb}}">
                                                        @error('tb')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                                </div>                          
                                            </div>
                                            <div class="row">                        
                                                <div class="col-8 col-sm-3">
                                                    <div class="form-group">
                                                            <label for="td">Tekanan Darah Ibu Hamil</label>
                                                            <input type="number" class="form-control @error('td') is-invalid @enderror form-control-sm" id="td" placeholder="Masukan Tekanan Darah Ibu Hamil" name="td" value="{{$ibu->td}}">
                                                            @error('td')
                                                                <div class="invalid-feedback">{{$message}}</div> 
                                                            @enderror
                                                        </div>
                                                    </div> 
                                                <div class="col-8 col-sm-3">
                                                    <div class="form-group" >
                                                        <label for="p_resiko">Penanganan Faktor Resiko</label>
                                                        <select  name="p_resiko" class="form-control" value="{{$ibu->p_resiko}}">
                                                            <option value="-" selected>Pilihan</option>
                                                            <option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
                                                            <option value="Non Tenaga Kesahatan">Non Tenaga Kesehatan</option>
                                                        </select>
                                                    </div>    
                                                </div> 
                                                <div class="col-8 col-sm-3">
                                                        <div class="form-group">
                                                            <label for="tgl_p_resiko">Tanggal Penanganan Resiko</label>
                                                            <input type="date" class="form-control form-control-lg" id="tgl_p_resiko" placeholder=" Tanggal Penanganan Resiko" name="tgl_p_resiko" value="{{$ibu->tgl_p_resiko}}">
                                                        </div> 
                                                    </div> 
                                                <div class="col-8 col-sm-3">
                                                    <div class="form-group">
                                                        <label for="ket">Keterangan Tambahan</label>
                                                        <input type="text" class="form-control @error('ket') is-invalid @enderror form-control-sm" id="ket" placeholder="Masukan Tinggi Badan Ibu Hamil" name="ket" value="{{$ibu->ket}}">
                                                        @error('ket')
                                                            <div class="invalid-feedback">{{$message}}</div> 
                                                        @enderror
                                                    </div>     
                                                </div>                                                     
                                            </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" onClick="return confirm('Edit Data Ibu ?') ">Edit Data </button>
                                        </div> 
                                    </div>
                                    </form>
								</div>
							</div>
            </div>
        </div>

        @endsection
<script src="{{asset('js/App.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('assets/vendor/chartist/js/chartist.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
<script>
	$(function() {
		var data, options;

		// headline charts
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[23, 29, 24, 40, 25, 24, 35],
				[14, 25, 18, 34, 29, 38, 44],
			]
		};

		options = {
			height: 300,
			showArea: true,
			showLine: false,
			showPoint: false,
			fullWidth: true,
			axisX: {
				showGrid: false
			},
			lineSmooth: false,
		};

		new Chartist.Line('#headline-chart', data, options);


		// visits trend charts
		data = {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			series: [{
				name: 'series-real',
				data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
			}, {
				name: 'series-projection',
				data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
			}]
		};

		options = {
			fullWidth: true,
			lineSmooth: false,
			height: "270px",
			low: 0,
			high: 'auto',
			series: {
				'series-projection': {
					showArea: true,
					showPoint: false,
					showLine: false
				},
			},
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: false,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 20,
				right: 20
			}
		};

		new Chartist.Line('#visits-trends-chart', data, options);


		// visits chart
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[6384, 6342, 5437, 2764, 3958, 5068, 7654]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};

		new Chartist.Bar('#visits-chart', data, options);


		// real-time pie chart
		var sysLoad = $('#system-load').easyPieChart({
			size: 130,
			barColor: function(percent) {
				return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
			},
			trackColor: 'rgba(245, 245, 245, 0.8)',
			scaleColor: false,
			lineWidth: 5,
			lineCap: "square",
			animate: 800
		});

		var updateInterval = 3000; // in milliseconds

		setInterval(function() {
			var randomVal;
			randomVal = getRandomInt(0, 100);

			sysLoad.data('easyPieChart').update(randomVal);
			sysLoad.find('.percent').text(randomVal);
		}, updateInterval);

		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

	});
	</script>