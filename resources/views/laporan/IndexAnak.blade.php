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
            <h3 style="margin-top:0;">Pencarian Grafik</h3>
          </div>
          <div class="modal-body">
            <form class="form-inline my-2 my-lg-2" style="padding:10px;  margin-top:8px;" method="post" action="/laporan_anak">
             @method('get')
                 <div class="form-group" >
                     <input type="hidden" name="jenis_laporan" value="Anak">
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
							<h3 class="heading">Laporan Pelayanan Anak dan Bayi</h3>
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
                                                    <th colspan="2" class="data">Kunjungan Anak Balita</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanK_anak as $laporanK_anak)
                                            @if($laporanK_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$loop->iteration}}</td>
                                                    <td>{{$laporanK_anak['nama_dusun']}}</td>
                                                    <td class="data">{{$laporanK_anak['L']}}</td>
                                                    <td class="data">{{$laporanK_anak['P']}}</td>
                                                    <td class="data">{{$laporanK_anak['L']+$laporanK_anak['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td colspan="2" class="data">TOTAL</td>
                                                    <td class="data">{{$jmlh_K_anak_L}}</td>
                                                    <td class="data">{{$jmlh_K_anak_P}}</td>
                                                    <td class="data">{{$jmlh_K_anak_L+$jmlh_K_anak_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Anak Prasekolah</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanP_anak as $laporanP_anak)
                                            @if($laporanP_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanP_anak['L']}}</td>
                                                    <td class="data">{{$laporanP_anak['P']}}</td>
                                                    <td class="data">{{$laporanP_anak['L']+$laporanP_anak['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_P_anak_L}}</td>
                                                    <td class="data">{{$jmlh_P_anak_P}}</td>
                                                    <td class="data">{{$jmlh_P_anak_L+$jmlh_P_anak_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Imunisasi Anak</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanI_anak as $laporanI_anak)
                                            @if($laporanI_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanI_anak['L']}}</td>
                                                    <td class="data">{{$laporanI_anak['P']}}</td>
                                                    <td class="data">{{$laporanI_anak['L']+$laporanI_anak['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_I_anak_L}}</td>
                                                    <td class="data">{{$jmlh_I_anak_P}}</td>
                                                    <td class="data">{{$jmlh_I_anak_L+$jmlh_I_anak_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <form action="/exportPDF" method="post">
                                            @csrf
                                            @method('get')
                                            <input type="hidden"value="anak" name="jenis_laporan">
                                            <input type="hidden"value="{{$keterangan_laporan['bulan']}}" name="bulan">
                                            <input type="hidden"value="{{$keterangan_laporan['tahun']}}" name="tahun">
                                            <button class="btn btn-outline-success " type="submit">Print</button>
                                        </form>
                                    
                                    </div>

                                    <br>
                                    <br>

                                    <div class="text-center">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="data">No </th>
                                                    <th rowspan="2">Nama Dusun</th>
                                                    <th colspan="2" class="data">Kunjungan Bayi</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanK_bayi as $laporanK_bayi)
                                            @if($laporanK_bayi['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$loop->iteration}}</td>
                                                    <td>{{$laporanK_bayi['nama_dusun']}}</td>
                                                    <td class="data">{{$laporanK_bayi['L']}}</td>
                                                    <td class="data">{{$laporanK_bayi['P']}}</td>
                                                    <td class="data">{{$laporanK_bayi['L']+$laporanK_bayi['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td colspan="2" class="data">TOTAL</td>
                                                    <td class="data">{{$jmlh_K_bayi_L}}</td>
                                                    <td class="data">{{$jmlh_K_bayi_P}}</td>
                                                    <td class="data">{{$jmlh_K_bayi_L+$jmlh_K_bayi_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Data Kelahiran Bayi</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanL_bayi as $laporanL_bayi)
                                            @if($laporanL_bayi['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanL_bayi['L']}}</td>
                                                    <td class="data">{{$laporanL_bayi['P']}}</td>
                                                    <td class="data">{{$laporanL_bayi['L']+$laporanL_bayi['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_L_bayi_L}}</td>
                                                    <td class="data">{{$jmlh_L_bayi_P}}</td>
                                                    <td class="data">{{$jmlh_L_bayi_L+$jmlh_L_bayi_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Imunisasi Bayi</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">L</th>
                                                    <th class="data">P</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanI_bayi as $laporanI_bayi)
                                            @if($laporanI_bayi['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanI_bayi['L']}}</td>
                                                    <td class="data">{{$laporanI_bayi['P']}}</td>
                                                    <td class="data">{{$laporanI_bayi['L']+$laporanI_bayi['P']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_I_bayi_L}}</td>
                                                    <td class="data">{{$jmlh_I_bayi_P}}</td>
                                                    <td class="data">{{$jmlh_I_bayi_L+$jmlh_I_bayi_P}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <form action="/exportPDF" method="post">
                                            @csrf
                                            @method('get')
                                            <input type="hidden"value="bayi" name="jenis_laporan">
                                            <input type="hidden"value="{{$keterangan_laporan['bulan']}}" name="bulan">
                                            <input type="hidden"value="{{$keterangan_laporan['tahun']}}" name="tahun">
                                            <button class="btn btn-outline-success " type="submit">Print</button>
                                        </form>
                                    
                                    </div>
                                    
                                    <br>
                                    <br>

                                    <div class="text-left">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="data">No </th>
                                                    <th rowspan="2">Nama Dusun</th>
                                                    <th colspan="2" class="data">Diare</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanDi_anak as $laporanDi_anak)
                                            @if($laporanDi_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$loop->iteration}}</td>
                                                    <td>{{$laporanDi_anak['nama_dusun']}}</td>
                                                    <td class="data">{{$laporanDi_anak['anak']}}</td>
                                                    <td class="data">{{$laporanDi_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanDi_anak['anak']+$laporanDi_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td colspan="2" class="data">TOTAL</td>
                                                    <td class="data">{{$jmlh_Di_anak}}</td>
                                                    <td class="data">{{$jmlh_Di_bayi}}</td>
                                                    <td class="data">{{$jmlh_Di_anak+$jmlh_Di_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Pneumonia</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanPn_anak as $laporanPn_anak)
                                            @if($laporanPn_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanPn_anak['anak']}}</td>
                                                    <td class="data">{{$laporanPn_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanPn_anak['anak']+$laporanPn_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Pn_anak}}</td>
                                                    <td class="data">{{$jmlh_Pn_bayi}}</td>
                                                    <td class="data">{{$jmlh_Pn_anak+$jmlh_Pn_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Malaria</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanMa_anak as $laporanMa_anak)
                                            @if($laporanMa_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanMa_anak['anak']}}</td>
                                                    <td class="data">{{$laporanMa_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanMa_anak['anak']+$laporanMa_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Ma_anak}}</td>
                                                    <td class="data">{{$jmlh_Ma_bayi}}</td>
                                                    <td class="data">{{$jmlh_Ma_anak+$jmlh_Ma_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Campak</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanCa_anak as $laporanCa_anak)
                                            @if($laporanCa_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanCa_anak['anak']}}</td>
                                                    <td class="data">{{$laporanCa_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanCa_anak['anak']+$laporanCa_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Ca_anak}}</td>
                                                    <td class="data">{{$jmlh_Ca_bayi}}</td>
                                                    <td class="data">{{$jmlh_Ca_anak+$jmlh_Ca_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">DBD</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanDb_anak as $laporanDb_anak)
                                            @if($laporanDb_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanDb_anak['anak']}}</td>
                                                    <td class="data">{{$laporanDb_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanDb_anak['anak']+$laporanDb_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Db_anak}}</td>
                                                    <td class="data">{{$jmlh_Db_bayi}}</td>
                                                    <td class="data">{{$jmlh_Db_anak+$jmlh_Db_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Diferi</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanAf_anak as $laporanAf_anak)
                                            @if($laporanAf_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanAf_anak['anak']}}</td>
                                                    <td class="data">{{$laporanAf_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanAf_anak['anak']+$laporanAf_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Af_anak}}</td>
                                                    <td class="data">{{$jmlh_Af_bayi}}</td>
                                                    <td class="data">{{$jmlh_Af_anak+$jmlh_Af_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="data">Lain-Lain</th>
                                                    <th rowspan="2" class="data">Total</th>
                                                </tr>
                                                <tr>
                                                    <th class="data">Anak</th>
                                                    <th class="data">Bayi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($laporanLn_anak as $laporanLn_anak)
                                            @if($laporanLn_anak['nama_dusun'] != "Luar Desa Lokasari")
                                                <tr>
                                                    <td class="data">{{$laporanLn_anak['anak']}}</td>
                                                    <td class="data">{{$laporanLn_anak['bayi']}}</td>
                                                    <td class="data">{{$laporanLn_anak['anak']+$laporanLn_anak['bayi']}}</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td class="data">{{$jmlh_Ln_anak}}</td>
                                                    <td class="data">{{$jmlh_Ln_bayi}}</td>
                                                    <td class="data">{{$jmlh_Ln_anak+$jmlh_Ln_bayi}}</td>
                                                </tr>
                                            </tbody>
                                        </table>



                                        <form action="/exportPDF" method="post" class="data">
                                            @csrf
                                            @method('get')
                                            <input type="hidden"value="anak_meninggal" name="jenis_laporan">
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
<script src="{{asset('js/data/cariTahun.js')}}"></script>



@endsection