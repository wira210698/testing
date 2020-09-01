<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export PDF</title>
    <style>
        p{
        font-size:18px;
        }
        table {
        border-collapse: collapse; 
        position:absolute;
        min-width:10px;
        font-size:16px; 
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
        .text-center{
            text-align:center;
        }
        .text-left{
            text-align:left;
        }
        .table0{
            margin-top:10px;
        }
        .table1{
            margin-top:1px;
            margin-left:230px;
        }
        .table2{
            margin-top:1px;
            margin-left:339px;
        }
        .table3{
            margin-top:1px;
            margin-left:446px;
        }
        .table4{
            margin-top:1px;
            margin-left:555px;
        }
        .table5{
            margin-top:1px;
            margin-left:662px;
        }
        .table6{
            margin-top:1px;
            margin-left:770px;
        }
        
    </style>
</head>
<body>
    <div class="text-center">
        <h2>Laporan Bulanan Anak Meninggal</h2>
        <h3>Desa Lokasari</h3>
    </div>
    <div class="text-left">
        <p>Kabupaten    : Karangasem</p>
        <p>Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{$keterangan_laporan}}</p>
    </div>

    <table class="table0">
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

    <table class="table1">
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

    <table class="table2">
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

    <table class="table3">
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

    <table  class="table4">
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

    <table  class="table5">
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

    <table class="table6">
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
</body>
</html>




