@extends('layout.main')

@section('title','Grafik')

@section('container'.'')
<style>
table {
  border-collapse: collapse; 
  display: inline-block;
  min-width:10px; 
  margin-left:-6px;
  margin-right:0;
}
/* Zebra striping */
tr:nth-of-type(odd) {
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold;
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  
}
.data{
    text-align: center; 
}
.text-left{
    font-size:11px;
    margin-right: 0px; 
}
</style>
<div class="modal fade modalCari" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header" style="height:50px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		    </button>
            <h3 style="margin-top:0;">Pencarian Laporan</h3>
          </div>
          <div class="modal-body">
            <form class="form-inline my-2 my-lg-2" style="padding:10px;  margin-top:8px;" method="post" action="/laporan_ibu">
             @method('get')
                 <div class="form-group" >
                     <input type="hidden" name="jenis_laporan" value="Ibu">
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
		          <button type="submit" class="btn btn-primary">Cari Laporan</button>
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
							<h3 class="heading">Laporan Pelayanan Ibu</h3>
                            @if($keterangan!="")
							<p class="heading">Bulan : {{$keterangan}}</p>
                            @endif
						</div>
						<div class="panel-body" style="min-height:450px;">
                            @if($keterangan_laporan!="")
							<div class="text-center">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="data">No </th>
                                                    <th rowspan="2">Nama Dusun</th>
                                                    <th colspan="2" class="data">Kunjungan Ibu</th>
                                                    <th rowspan="2" class="data">Status</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Bulan lalu</th>
                                                    <th class="data">Bulan Ini</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanK as $laporanK)
                                            @if($laporanK['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$loop->iteration}}</td>
                                                    <td>{{$laporanK['nama_dusun']}}</td>
                                                    <td class="data">{{$laporanK['bulan_lalu']}}</td>
                                                    <td class="data">{{$laporanK['bulan_ini']}}</td>
                                                    @if($laporanK['bulan_ini']>$laporanK['bulan_lalu'])
                                                    <td class="data">Naik</td>
                                                    @elseif($laporanK['bulan_ini']<$laporanK['bulan_lalu'])
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td colspan="2" class="data">TOTAL</td>
                                                    <td class="data">{{$jmlhKunjunganBlnLalu}}</td>
                                                    <td class="data">{{$jmlhKunjunganBlnini}}</td>
                                                    @if($jmlhKunjunganBlnini>$jmlhKunjunganBlnLalu)
                                                    <td class="data">Naik</td>
                                                    @elseif($jmlhKunjunganBlnini<$jmlhKunjunganBlnLalu)
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Persalinan Ibu</th>
                                                    <th rowspan="2" class="data">Status</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Bulan lalu</th>
                                                    <th class="data">Bulan Ini</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanP as $laporanP)
                                            @if($laporanP['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanP['bulan_lalu']}}</td>
                                                    <td class="data">{{$laporanP['bulan_ini']}}</td>
                                                    @if($laporanP['bulan_ini']>$laporanP['bulan_lalu'])
                                                    <td class="data">Naik</td>
                                                    @elseif($laporanP['bulan_ini']<$laporanP['bulan_lalu'])
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlhPersalinanBlnlalu}}</td>
                                                    <td class="data">{{$jmlhPersalinanBlnini}}</td>
                                                    @if($jmlhPersalinanBlnini>$jmlhPersalinanBlnlalu)
                                                    <td class="data">Naik</td>
                                                    @elseif($jmlhPersalinanBlnini<$jmlhPersalinanBlnlalu)
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Ibu Menyusui</th>
                                                    <th rowspan="2" class="data">Status</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Bulan lalu</th>
                                                    <th class="data">Bulan Ini</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanM as $laporanM)
                                            @if($laporanM['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanM['bulan_lalu']}}</td>
                                                    <td class="data">{{$laporanM['bulan_ini']}}</td>
                                                    @if($laporanM['bulan_ini']>$laporanM['bulan_lalu'])
                                                    <td class="data">Naik</td>
                                                    @elseif($laporanM['bulan_ini']<$laporanM['bulan_lalu'])
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlhMenyusuiBlnlalu}}</td>
                                                    <td class="data">{{$jmlhMenyusuiBlnini}}</td>
                                                    @if($jmlhMenyusuiBlnini>$jmlhMenyusuiBlnlalu)
                                                    <td class="data">Naik</td>
                                                    @elseif($jmlhMenyusuiBlnini<$jmlhMenyusuiBlnlalu)
                                                    <td class="data">Turun</td>
                                                    @else
                                                    <td class="data">Sama</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                        <form action="/exportPDF" method="post">
                                            @csrf
                                            @method('get')
                                            <input type="hidden"value="{{$keterangan_laporan['jenis_laporan']}}" name="jenis_laporan">
                                            <input type="hidden"value="{{$keterangan_laporan['bulan']}}" name="bulan">
                                            <input type="hidden"value="{{$keterangan_laporan['tahun']}}" name="tahun">
                                            <button class="btn btn-outline-success " type="submit">Print</button>
                                        </form>
                                    </div>
                                @endif
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

@endsection