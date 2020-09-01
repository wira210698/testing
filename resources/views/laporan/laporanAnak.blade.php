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
        font-size:18px; 
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
            margin-left:326px;
        }
        .table2{
            margin-top:1px;
            margin-left:474px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>Laporan Bulanan Pelayana Anak Balita</h2>
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

        <table class="table1">
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
        
        <table class="table2">
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
    
    </div>
</body>
</html>




