@extends('layout.main')

@section('title','Laporan Ibu')

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
</style>
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid" >
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h1 class="mt-3">Laporan Ibu</h1>
                                <form class="form-inline my-2 my-lg-2" style="padding:10px;  margin-top:8px;" method="post" action="/ibu/laporan/create">
		                    	@method('get')
                                    <div class="form-group" >
                                        <label for="jenis_laporan">Jenis Laporan</label>
                                        <select name="jenis_laporan" id="jenis_laporan" class="form-control"style="margin-left:5px;margin-right:5px;">
                                                <option value="Ibu">Ibu</option>
                                                <option value="Persalinan Ibu">Persalinan Ibu</option>
                                                <option value="Ibu Menyusui">Ibu Menyusui</option>
                                        </select>
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
                                    
		                    		<button class="btn btn-outline-success " type="submit">Search</button>
		                    	</form>
                            </div>
                                <div class="panel-body" style="height:850px;">
                                <div class="table-responsive">
                                @if($laporanK !="")
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
                                                 <th colspan="2" class="data">Menyusui Ibu</th>
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
                                    
                                @endif
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
@stop