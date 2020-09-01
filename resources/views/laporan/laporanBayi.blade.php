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
            margin-left:281px;
        }
        .table2{
            margin-top:1px;
            margin-left:450px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>Laporan Bulanan Pelayana Bayi</h2>
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

        <table class="table1">
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
        
        <table class="table2">
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
    </div>
</body>
</html>




