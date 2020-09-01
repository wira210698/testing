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
        font-size:24px; 
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
            margin-left:405px;
        }
        .table2{
            margin-top:1px;
            margin-left:630px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>Laporan Bulanan Pelayana Ibu</h2>
        <h3>Desa Lokasari</h3>
    </div>
    <div class="text-left">
        <p>Kabupaten    : Karangasem</p>
        <p>Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{$keterangan_laporan}}</p>
    </div>

    <div class="text-center">
     <table class="table0">
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
     <table class="table1">
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
     
     <table class="table2">
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
 </div>
</body>
</html>




